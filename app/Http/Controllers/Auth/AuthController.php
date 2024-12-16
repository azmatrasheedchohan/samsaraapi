<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Http;
  

class AuthController extends Controller

{
    public function index()
    {
        return view('auth.login');
    }  
    public function registration()

    {
        return view('auth.registration');
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('admin/dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');

    }
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $this->create($data);
        return redirect("admin/dashboard")->withSuccess('Great! You have Successfully loggedin');

    }
    public function dashboard()
    {
        if(Auth::check()){
            $apiKey = env('SAMSARA_API_KEY');
            $baseUrl = "https://api.samsara.com";
    
            $ch = curl_init();
    
            // Set the URL for the drivers endpoint
            curl_setopt($ch, CURLOPT_URL, $baseUrl . "/fleet/drivers");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            // Set headers
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $apiKey",
                "Content-Type: application/json"
            ]);
    
            // Execute the request
            $response = curl_exec($ch);
    
            if (curl_errno($ch)) {
                echo "Error: " . curl_error($ch);
            } else {
                // Decode JSON response
                $drivers = json_decode($response, true);
    
                return view('dashboard',compact('drivers'));
            }
        }
        return redirect("login")->withSuccess('Opps! You do not have access');

    }




    public function addresses()
    {
        if (Auth::check()) {
            $apiKey = env('SAMSARA_API_KEY');
            $baseUrl = "https://api.samsara.com/addresses";
    
            // Make API call
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'authorization' => "Bearer {$apiKey}",
            ])->withoutVerifying()->get($baseUrl);
            
    
            // Check for success
            if ($response->successful()) {
                $addresses = $response->json(); // Decode JSON response
                return view('addresses', compact('addresses'));
            } else {
                // Log or handle errors
                $error = $response->json();
                return back()->withErrors(['error' => 'Failed to fetch addresses.']);
            }
        }
    
        return redirect("login")->with('error', 'Oops! You do not have access');
    }

    public function createaddresses()
    {
        return view('routeCreate');
    }


    public function addressesStore(Request $request)
    {
       
        $validated = $request->validate([
            'name' => 'required',
            'addressTypes' => 'required|array',
            'contactIds' => 'required|array',
            'externalIds.maintenanceId' => 'required|string',
            'externalIds.payrollId' => 'required|string',
            'formattedAddress' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'notes' => 'nullable|string',
            'tagIds' => 'required|array',
        ]);

        $payload = [
            'addressTypes' => $validated['addressTypes'],
            'contactIds' => $validated['contactIds'],
            'externalIds' => $validated['externalIds'],
            'formattedAddress' => $validated['formattedAddress'],
            'geofence' => [
                'circle' => [
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                    'radiusMeters' => 25,
                ],
                'polygon' => [
                    'vertices' => [
                        [
                            'latitude' => $validated['latitude'],
                            'longitude' => $validated['longitude'] + 0.0001,
                        ],
                        [
                            'latitude' => $validated['latitude'] + 1.0,
                            'longitude' => $validated['longitude'] + 0.0001,
                        ],
                        [
                            'latitude' => $validated['latitude'],
                            'longitude' => $validated['longitude'] - 1.0,
                        ],
                    ],
                ],
                'settings' => ['showAddresses' => true],
            ],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'name' => $validated['name'],
            'notes' => $validated['notes'],
            'tagIds' => $validated['tagIds'],
        ];
        $apiKey = env('SAMSARA_API_KEY');

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'authorization' => 'Bearer ' . env('SAMSARA_API_KEY'),
            'content-type' => 'application/json',
        ])
        ->withoutVerifying()  // Disable SSL verification
        ->post('https://api.samsara.com/addresses', $payload);
        

if ($response->failed()) {
    return response()->json([
        'message' => 'Failed to create address: ' . $response->body(),
        'requestId' => $response->json('requestId')
    ], 400);
}

return $response->json();

    }

    public function user()
    {
        if(Auth::check()){
            $apiKey = env('SAMSARA_API_KEY');
            $baseUrl = "https://api.samsara.com";
    
            $ch = curl_init();
    
            // Set the URL for the drivers endpoint
            curl_setopt($ch, CURLOPT_URL, $baseUrl . "/fleet/drivers");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            // Set headers
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $apiKey",
                "Content-Type: application/json"
            ]);
    
            // Execute the request
            $response = curl_exec($ch);
    
            if (curl_errno($ch)) {
                echo "Error: " . curl_error($ch);
            } else {
                // Decode JSON response
                $drivers = json_decode($response, true);
    
                return view('user',compact('drivers'));
            }
            return view('user');
        }
        return redirect("login")->withSuccess('Opps! You do not have access');

    }
    public function create(array $data)

    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }

}