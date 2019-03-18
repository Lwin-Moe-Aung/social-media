<?php

namespace App\Library\Log;

use App\Library\Log\Contracts\Log;
use App\Loginfo;
use Illuminate\Http\Request;
use DB;

class DBlog implements Log
{


      /*
       * log table format to insert
       */
      public function format($detail, $table, $user_id)
      {
          
          $data = [

              "user_id" => $user_id,
              "detail" => $detail,
              "table" => $table,
              "date" => date('Y-m-d h:i:s'),
              'url' => url()->current()

          ];
          return $data;
      }

      /*
       * Insert log data into database
       */
      public function save($data)
      {
          Loginfo::create($data);
      }

      /*
       * Retrieve all the logs from database or
       * Retrieve a log info according to parameter(table field)
       */
      public function show($name)
      {
         
      }
}