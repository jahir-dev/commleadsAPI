<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\models\Buyer;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator, DB, Hash, Mail, Illuminate\Support\Facades\Password;
class AuthController extends Controller
{
    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $credentials = $request->only('firstName', 'lastName', 'password', 'address', 'phone', 'country_id', 'email');
        $rules = [
            // 'username' => 'required|max:255|unique:users',
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:8|min:8',
            'country_id' => 'required',
            'email' => 'required|email|max:255|unique:users',  
            'password' => 'required|min:6',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

        $buyer = new Buyer();
        $buyer->firstName = $request->firstName;
        $buyer->lastName = $request->lastName;
        $buyer->address = $request->address;
        $buyer->phone = $request->phone;
        $buyer->email = $request->email;
        $buyer->password = Hash::make($request->password);

        $buyer->country()->associate($request->country_id);

        $buyer->isActive = true;
        $buyer->isPremium = false;
        $buyer->isExpired = false;
        $buyer->registrationDate = new \DateTime();
        $buyer->lastLoginDate = new \DateTime();
        $buyer->numberOfLogs = 0;

        try{
            $buyer->save();
            /*return response()->json([
                'status' => '200',
                'message' => 'Buyer created!'
            ],200);*/
        }
        catch (\Exception $e){
            return response()->json([
                'status' => '500',
                'message' => 'Could not create buyer',
                'error' => $e->getMessage()
            ]);
        }
        return $this->login($request);
    }


    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        // all good so return the token
        return response()->json(['success' => true, 'data'=> [ 'token' => $token ]]);
    }
    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);
        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }

    /**
     * API Recover Password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recover(Request $request)
    {
        $buyer = Buyer::where('email', $request->email)->first();
        if (!$buyer) {
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }
        try {
            Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject('Your Password Reset Link');
            });
        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 401);
        }
        return response()->json([
            'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
        ]);
    }
}