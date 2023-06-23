<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rental = Rental::all();

        if($rental)
        {
            return ApiFormatter::createApi(200, 'success', $rental);
        }else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'nama' => 'required',
                'alamat' => 'required',
                'type' => 'required',
                'waktu_jam' => 'required',
                'jam_mulai' => 'required',
                'supir' => 'required',
            ]);

            $harga = $request->waktu_jam * 150000;

            $rental = Rental::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'type' => $request->type,
                'waktu_jam' => $request->waktu_jam,
                'total_harga' => $harga,
                'jam_mulai' =>$request->jam_mulai,         
                'supir' => $request->supir,

            ]);

            $datasavd = Rental::where('id', $rental->id)->first();

            if ($datasavd){
                return ApiFormatter::createApi(200, 'Berhasil Menambahkan Data!', $datasavd);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental, $id)
    {
        try{
            $rentalShow = Rental::where('id', $id)->first();
        
            if ($rentalShow) {
                return ApiFormatter::createApi(200, 'success', $rentalShow);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental, $id)
    {
        try{
            $request->validate([
                'jam_selesai' => 'required',
                'tempat_tujuan' => 'required'
            ]);

            $rental = Rental::findOrFail($id);

            $riwayat = 'Dimulai pada jam ' . $rental->jam_mulai . ' dengan titik penjemputan di ' . $rental->alamat . ' Dan selesai pada jam ' . $request->jam_selesai . ' dengan titik akhir di ' . $request->tempat_tujuan;

            $rental->update([
                'jam_selesai' => $request->jam_selesai,
                'tempat_tujuan' => $request->tempat_tujuan,
                'riwayat_perjalanan' => $riwayat,
                'status' => 'selesai',

                

            ]);
            $updateRental = Rental::where('id', $rental->id);
            if ($updateRental) {
                return ApiFormatter::createApi(200, 'succsess', $updateRental);
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }

        }
        catch(Exception $error){
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental, $id)
    {
        try{
            $rental = Rental::where('id', $id);
            $deletes = $rental->delete();

            if ($deletes) {
                return ApiFormatter::createApi(200, 'succsess', $deletes);
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }

        }
        catch(Exception $error){
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    public function trash()
    {
        try{
            $trash = Rental::onlyTrashed()->get();
        
            if ($trash) {
                return ApiFormatter::createApi(200, 'success', $trash);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);

        }
    }

    public function restore($id)
    {
        try 
        {
        $restore = Rental::onlyTrashed()->where('id', $id);
        $data = $restore->restore();
        if ($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        }else {
            return ApiFormatter::createApi(400, 'failed');
        }
    } catch (Exception $error) {
        return ApiFormatter::createApi(400, 'failed', $error);
        
     }
  }
    
  public function permanentDelete($id)
  {
        try {
         $deletePermanent = Rental::onlyTrashed()->where('id', $id);
         $rental =$deletePermanent->forceDelete();

        if ($rental) {
            return ApiFormatter::createApi(200, 'success', $rental);
        }else {
            return ApiFormatter::createApi(400, 'failed');
        }
    } catch (Exception $error) {
        return ApiFormatter::createApi(400, 'failed', $error);
        
    }
  }

}
