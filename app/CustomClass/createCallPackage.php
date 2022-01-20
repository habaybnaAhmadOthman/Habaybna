<?php

namespace app\CustomClass;

use App\Calls;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;

class createCallPackage {

    public function execute(array $data)
    {

        try {
            if(Calls::whereTitle($data['title'])->first()){
                return response()->json(409);
            }

            $call_package = new Calls();

            if($data['package_durations']){
                $call_package->start_date = date("Y-m-d", strtotime($data['package_durations']['start_date']));
                $call_package->end_date = date("Y-m-d", strtotime($data['package_durations']['end_date']));
            }
            $call_package->title = $data['title'];
            $call_package->status = $data['status'];
            $call_package->price = $data['price'];
            $call_package->type = $data['type'];
            $call_package->calls_count = $data['call_count'];

            $call_package->save();

            return $call_package;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
