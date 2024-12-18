<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.samsara.com',
            'headers' => [
                'Authorization' => 'Bearer ' . env('SAMSARA_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'verify' => false, // Disable SSL verification (optional, for development purposes)
        ]);
    }

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
                ->withSuccess('You have Successfully logged in');
        }

        return redirect("login")->withSuccess('Oops! You have entered invalid credentials');
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

        return redirect("admin/dashboard")->withSuccess('Great! You have Successfully registered');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            try {
                $response = $this->client->get('/fleet/drivers');
                $drivers = json_decode($response->getBody()->getContents(), true);

                return view('dashboard', compact('drivers'));
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Failed to fetch drivers: ' . $e->getMessage()]);
            }
        }

        return redirect("login")->withSuccess('Oops! You do not have access');
    }

    public function addresses()
    {
        if (Auth::check()) {
            try {
                $response = $this->client->get('/addresses');
                $addresses = json_decode($response->getBody()->getContents(), true);

                return view('addresses', compact('addresses'));
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Failed to fetch addresses: ' . $e->getMessage()]);
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
            'name' => 'required|string',
            'addressTypes' => 'required|array',
            'contactIds' => 'required|array',
            'externalIds.maintenanceId' => 'required|string',
            'externalIds.payrollId' => 'required|string',
            'formattedAddress' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'notes' => 'nullable|string',
            'tagIds' => 'required|array',
            'geofenceType' => 'string|in:circle,polygon',
        ]);

        $validated['geofenceType'] = "circle";

        $payload = [
            'addressTypes' => $validated['addressTypes'],
            'contactIds' => $validated['contactIds'],
            'externalIds' => $validated['externalIds'],
            'formattedAddress' => $validated['formattedAddress'],
            'geofence' => ['settings' => ['showAddresses' => true]],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'name' => $validated['name'],
            'notes' => $validated['notes'],
            'tagIds' => $validated['tagIds'],
        ];

        if ($validated['geofenceType'] === 'circle') {
            $payload['geofence']['circle'] = [
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'radiusMeters' => 20,
            ];
        } elseif ($validated['geofenceType'] === 'polygon') {
            $payload['geofence']['polygon'] = [
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
            ];
        }

        try {
            $response = $this->client->post('/addresses', ['json' => $payload]);

            if ($response->getStatusCode() !== 200) {
                return response()->json([
                    'message' => 'Failed to create address',
                    'details' => json_decode($response->getBody(), true),
                ], $response->getStatusCode());
            }

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function user()
    {
        if (Auth::check()) {
            try {
                $response = $this->client->get('/fleet/drivers');
                $drivers = json_decode($response->getBody()->getContents(), true);

                return view('user', compact('drivers'));
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Failed to fetch drivers: ' . $e->getMessage()]);
            }
        }

        return redirect("login")->withSuccess('Oops! You do not have access');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
