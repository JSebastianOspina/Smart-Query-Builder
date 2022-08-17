<?php

use Ospina\SmartQueryBuilder\SmartQueryBuilder;

require './src/SmartQueryBuilder.php';

$smartQueryBuilder = SmartQueryBuilder::table('roles')
->select([
    'campo1','campo2','campo3'
])
    ->where(1,'=',1)
    ->where('name','>','algo');

echo $smartQueryBuilder->getQuery();


$smartQueryBuilder = SmartQueryBuilder::table('roles')
    ->update([
        'campo1' => 'Nuevo valor1',
        'campo2' => 'Nuevo valor2',
        'campo3' => 'Nuevo valor2',

    ])
    ->where(1,'=',1)
    ->where('name','>','algo');

echo $smartQueryBuilder->getQuery();


$smartQueryBuilder = SmartQueryBuilder::table('roles')
    ->insert([
        'campo1' => 'Nuevo valor1',
        'campo2' => 'Nuevo valor2',
        'campo3' => 'Nuevo valor2',

    ])
    ->where(1,'=',1)
    ->where('name','>','algo');

echo $smartQueryBuilder->getQuery();