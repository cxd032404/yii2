<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use Elasticsearch\ClientBuilder;

/**
 * Site controller
 */
class IndexController extends Controller
{
    /**
     * {@inheritdoc}
     */


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        echo "Here";
        $redis = \Yii::$app->redis;
        $redis_key = "test_redis";
        echo $redis->incrby($redis_key,rand(1,9));

        $client = ClientBuilder::create()->setHosts(['127.0.0.1:9200'])->build();

        $pa =
            [
                'index'=>'test_index',
                'type'=>'test_type',
                'body'=>
                    ['query'=>
                        ['bool'=>
                            ['must'=>
                                ['multi_match'=>
                                    ['query'=>1,'operator'=>'AND']
                                ]
                            ]
                        ]
                    ]
            ];
        $search_return = json_decode(json_encode($client->search($pa)),true);

        print_R($search_return);
        //return $this->render('index');
    }
}
