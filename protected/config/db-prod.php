<?php
				return [
				'class' => 'yii\db\Connection',
				'dsn' => 'mysql:host=127.0.0.1;dbname=AdminProject',
				'emulatePrepare' => true,
				'username' => 'admin',
				'password' => 'admin@123',
				'charset' => 'utf8',
				'tablePrefix' => 'tbl_',
                'enableSchemaCache' => 1 ,
                'schemaCacheDuration' => 3600,
                'schemaCache' => 'cache',
				];