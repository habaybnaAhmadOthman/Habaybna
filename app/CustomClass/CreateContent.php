<?php

namespace app\CustomClass;

use App\Content;
use App\PromoCode;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;

class CreateContent {

    public function execute(array $data)
    {
        try {

            $content = new Content();

            



        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
