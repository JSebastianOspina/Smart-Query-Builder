<?php

use Ospina\SmartQueryBuilder\SmartQueryBuilder;

require './src/SmartQueryBuilder.php';

$smartQueryBuilder = SmartQueryBuilder::table('form_answers')
    ->select([
        '*'
    ])
    ->where(1, '=', 1)
    ->limit(4, 4);

echo nl2br($smartQueryBuilder->getQuery()."\n");


$smartQueryBuilder = SmartQueryBuilder::table('roles')
    ->update([
        'campo1' => 'Nuevo valor1',
        'campo2' => 'Nuevo valor2',
        'campo3' => 'Nuevo valor2',

    ])
    ->where('name', '=', 'pepe')
    ->where('name', '>', 'algo')
    ->limit(10);

echo nl2br($smartQueryBuilder->getQuery()."\n");


$smartQueryBuilder = SmartQueryBuilder::table('roles')
    ->insert([
        'campo1' => 'Nuevo valor1',
        'campo2' => 'Nuevo valor2',
        'campo3' => 'Nuevo valor2',

    ])
    ->where(1, '=', 1)
    ->where('name', '>', 'algo');

echo nl2br($smartQueryBuilder->getQuery()."\n");
