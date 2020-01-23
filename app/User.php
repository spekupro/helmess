<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $fillable = [
        'name', 'agreed_terms'
    ];

    protected $primaryKey = 'user_id';

    public static function validateAgreedToTerms($agreed_terms)
    {
        if ($agreed_terms == 'on')
            return 1;
        else
            return back();
    }

    public static function getUserSectors($user_id)
    {
        $data = DB::table('user_sectors')->where('user_id', '=', $user_id)->get();

        $sectorsArray = array();
        foreach ($data as $row)
        {
            $usersSectors = DB::table('sectors')->select('sector_name')->where('sector_id', '=', $row->sector_id)->get();
            foreach ($usersSectors as $sector)
            {
                $sectorsArray[$row->sector_id] = $sector->sector_name;
            }
        }

        return $sectorsArray;
    }

    public static function validateRequest($request)
    {
        $validatedRequest = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'sectors' => ['required', 'array', 'min:1'],
            'agreed_terms' => 'required'
        ]);

        return $validatedRequest;
    }

    public function user()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
