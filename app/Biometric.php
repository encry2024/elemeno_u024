<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Biometric extends Model
{
   use SoftDeletes;

   /**
    * Store Biometric Device Function
    * $request - Biometric Device information
    */
   public static function storeBiometricRequest($request)
   {
      $biometric        = new Biometric();
      $biometric->name  = $request->get('name');
      $biometric->sn    = $request->get('sn');
      $biometric->vc    = $request->get('vc');
      $biometric->ac    = $request->get('ac');
      $biometric->vkey  = $request->get('vkey');

      if($biometric->save()) {
         return redirect()->back()->with('msg', 'Biometric Device "' . $biometric->name . '" was successfully added.');
      }

      return redirect()->back()->with('msg', 'Error in adding new Biometric Device.');
   }
}
