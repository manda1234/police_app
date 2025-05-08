<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index()
    {
       
        $vehicles = Vehicle::where('user_id', Auth::id())->get();

        return response()->json([
            'status' => 'success',
            'message' => 'daftar kendaraan berhasil diambil.',
            'data' => $vehicles
        ]);
    }

    public function store(Request $request)
    {
    
        $request->validate([
            'license_plate' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|string',
            'color' => 'required|string',
            'is_stolen' => 'required|boolean',
        ]);

        
        $vehicle = Vehicle::create([
            'user_id' => Auth::id(),
            'license_plate' => $request->license_plate,
            'type' => $request->type,
            'brand' => $request->brand,
            'color' => $request->color,
            'is_stolen' => $request->is_stolen,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Kendaraan Berhasil dibuat.',
            'data' => $vehicle
        ], 201);
    }

    public function show($id)
    {
       
        $vehicle = Vehicle::where('user_id', Auth::id())->where('id', $id)->first();

        if (!$vehicle) {
            
            return response()->json([
                'status' => 'error',
                'message' => 'kendaraan tidak ditemukan.',
                'data' => []
            ], 404);
        }

        
        return response()->json([
            'status' => 'success',
            'message' => 'Kendaraan ditemukan.',
            'data' => $vehicle
        ]);
    }

    public function update(Request $request, $id)
    {
   
        $vehicle = Vehicle::where('user_id', Auth::id())->where('id', $id)->first();

        if (!$vehicle) {
          
            return response()->json([
                'status' => 'error',
                'message' => 'Kendaraan tidak ditemukan.',
                'data' => []
            ], 404);
        }

      
        $vehicle->update($request->only(['license_plate', 'type', 'brand', 'color', 'is_stolen']));

        return response()->json([
            'status' => 'success',
            'message' => 'kendaraan berhasil diperbaharui .',
            'data' => $vehicle
        ]);
    }

    public function destroy($id)
    {
        
        $vehicle = Vehicle::where('user_id', Auth::id())->where('id', $id)->first();

        if (!$vehicle) {
            
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found.',
                'data' => []
            ], 404);
        }

      
        $vehicle->delete();

        
        return response()->json([
            'status' => 'success',
            'message' => 'kendaraan berhasil dihapus.',
            'data' => []
        ]);
    }
}
