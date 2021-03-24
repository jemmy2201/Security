<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use function GuzzleHttp\Promise\all;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
//        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($request->type_login == non_barcode) {
            // api cek sinpass
            if (true) { // check login singpass
                $response = Http::get('https://sandbox.api.myinfo.gov.sg/com/v3/person-sample/S9812381D');
                if ($response->status() == "200") {
                    $response = $response->json();
                    $users = User::where('nric', $response['sponsoredchildrenrecords'][0]['nric'])->orWhere('fin', $response['uinfin']['value'])->first();
                    if (!empty($users)) {
                        $data = $this->diff_data($response, $users, $request);
                    } else {
                        $data = $this->newuser($request, $response);
                    }
                }
            }
        }

        $email = array("email" => $data->email);
        $request->merge($email);

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    protected function newuser($request,$response)
    {
        $time = Carbon::now();

        $InUser = new User;

        $InUser->name = $response['aliasname']['value'];

        $InUser->email = $response['email']['value'];

        $InUser->password = Hash::make($request->password);

        $InUser->nric =$response['sponsoredchildrenrecords'][0]['nric']['value'];

        $InUser->fin =$response['uinfin']['value'];

        $InUser->passportexpirydate =$response['passportexpirydate']['value'];

        $InUser->passexpirydate =$response['passportexpirydate']['value'];

        $InUser->passportnumber =$response['passportnumber']['value'];

        $InUser->mobileno =$response['mobileno']['prefix']['value'].''.$response['mobileno']['areacode']['value'].''.'-'.$response['mobileno']['nbr']['value'];

        $InUser->photo =$response['drivinglicence']['photocardserialno']['value'];

        $InUser->time_login_at =$time->toDateTimeString();

        $InUser->save();

        return $InUser;
    }

    protected function updateuser($result,$users,$request)
    {
        $time = Carbon::now();

        $UpdateUser = User::find($users->id);

        if (!empty($result['name'])){
            $UpdateUser->name = $result['name'];
        }
        if (!empty($result['email'])) {
            //$InUser->email = $response['email']['value'];
            $UpdateUser->email = $result['email'];
        }
        if (!empty($result['password'])) {
            $UpdateUser->password = $result['password'];
        }
        if (!empty($result['sponsoredchildrenrecords'])) {
            $UpdateUser->nric = $result['sponsoredchildrenrecords'];
        }

        if (!empty($result['uinfin'])) {
            $UpdateUser->fin = $result['uinfin']['value'];
        }
        if (!empty($result['passportexpirydate'])) {
            $UpdateUser->passportexpirydate = $result['passportexpirydate'];
        }
        if (!empty($result['passportexpirydate'])) {
            $UpdateUser->passexpirydate = $result['passportexpirydate'];
        }
        if (!empty($result['passportnumber'])) {
            $UpdateUser->passportnumber = $result['passportnumber'];
        }

        if (!empty($result['mobileno'])) {
            $UpdateUser->mobileno = $result['mobileno'];
        }

        if (!empty($result['photo'])) {
            $UpdateUser->photo = $result['photo'];
        }

        if (!empty($result['time_login_at'])) {
            $UpdateUser->time_login_at = $result['time_login_at'];
        }

        $UpdateUser->save();

        return $UpdateUser;
    }

    protected function diff_data($response,$users,$request)
    {
        $time = Carbon::now();
        $originData=array("name"=>$response['aliasname']['value'],
            "email"=>$response['email']['value'],
            "password"=>Hash::make($request->password),
            "nric"=>$response['sponsoredchildrenrecords'][0]['nric']['value'],
            "fin"=>$response['uinfin']['value'],
            "passportexpirydate"=>$response['passportexpirydate']['value'],
            "passexpirydate"=>$response['passexpirydate']['value'],
            "passportnumber"=>$response['passportnumber']['value'],
            "mobileno"=>$response['mobileno']['prefix']['value'].''.$response['mobileno']['areacode']['value'].''.'-'.$response['mobileno']['nbr']['value'],
            "photo"=>$response['drivinglicence']['photocardserialno']['value'],
            "time_login_at"=>$time->toDateTimeString()
        );

        $result=array_diff($originData,$users->toArray());

        $data = $this->updateuser($result,$users,$request);

        return $data;
    }
}
