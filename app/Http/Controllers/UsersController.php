<?php

namespace App\Http\Controllers;

use App\UserSectors;
use Illuminate\Http\Response;
use App\Sector;
use App\User;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sectors = Sector::all();
        $users = User::orderBy('updated_at', 'desc')->simplePaginate(5);

        return response()
            ->view('welcome', compact(['sectors', 'users']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $user = new User();
        $request = $user->validateRequest(request());
        $user->name = $request['name'];
        $user->agreed_terms = $user->validateAgreedToTerms($request['agreed_terms']);
        $user->save();

        $sectors = $request['sectors'];

        foreach ($sectors as $sector)
        {
            $user_sector = new UserSectors();
            $user_sector->user_id = $user->user_id;
            $user_sector->sector_id = $sector;
            $user_sector->save();
        }
        return redirect('/')->withInput(request()->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::where('user_id', $id)->first();
        $sectors = Sector::all();
        $user_sectors = User::getUserSectors($id);

        return response()
            ->view('user.edit', compact(['user', 'sectors', 'user_sectors']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $user = User::where('user_id', $id)->first();
        $request = $user->validateRequest(request());

        $user->name = $request['name'];
        $user->agreed_terms = User::validateAgreedToTerms($request['agreed_terms']);

        $sectors = $request['sectors'];
        $user_sectors = User::getUserSectors($id);

        foreach ($sectors as $sector)
        {
            if (!array_key_exists($sector, $user_sectors))
            {
                $user_sector = new UserSectors();
                $user_sector->user_id = $user->user_id;
                $user_sector->sector_id = $sector;
                $user_sector->save();
            }
        }

        foreach ($user_sectors as $key => $user_sector)
        {
            if (!in_array($key, $sectors))
            {
                DB::table('user_sectors')->where('user_id', $id)->where('sector_id', $key)->delete();
            }
        }

        $user->updated_at = date("Y-m-d H:i:s");
        $user->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        UserSectors::where('user_id', $id)->delete();

        return redirect('/');
    }
}
