<?php

namespace Src\Database;

use Config\App;

class EntityService
{


    public function __construct(protected Database $db){
    }

    public function getDatabaseConnection()
    {
        return $this->db;
    }

}