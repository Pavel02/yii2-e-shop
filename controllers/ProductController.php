<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;
use yii\web\HttpException;

class ProductController extends AppController
{
    public function actionView($id)         // Здесь параметр получается из строки запроса (его разбирает роутер), а можно из массива GET
    {
            // Получаем id товара из массива  GET.
        $id = Yii::$app->request->get('id');
            // Первый вариант с ленивой загрузкой.   В $product  у нас будет храниться объект категории.
        $product = Product::findOne($id);
        if (empty($product))
            throw new HttpException(404, 'Такого товара нет');
            // Второй вариант с жадной загрузкой
//        $product = Product::find()->with('category')->where('id' => $id)->limit(1)->one();
            // получаем 5 товаров хитов из таблицы продуктов, где поле hit = 1.
        $hits = Product::find()->where(['hit' => '1'])->limit(5)->all();
            // реализуем метатеги
        $this->setMeta('E-Shopper | ' . $product->name, $product->keywords, $product->description);
        return $this->render('view', compact('product', 'hits'));
    }
}