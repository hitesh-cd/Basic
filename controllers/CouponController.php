<?php namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use Yii;
use app\models\Coupon;
use app\models\Website;
use PHPExcel;

class CouponController extends Controller
{

    public function actionTest()
    {
        $query_coupons = Coupon::find();

        $coupons = $query_coupons->with('website')
            ->limit(1)
            ->all();
        //$categories = $coupons->website;
        var_dump($coupons);
//        var_dump($categories);

        exit();
    }

    public function actionIndex()
    {
        $query_coupons = Coupon::find(); //coupons object
        //pagination object
        $pagination = new Pagination([
            'defaultPageSize' => 30,
            'totalCount' => $query_coupons->count(),
        ]);

        $query_vendors = \app\models\Website::find(); //making vendors object

        $query_categories = \app\models\CouponCategories::find(); //categories object

        $vendors = $query_vendors->orderBy('WebsiteName') //fetchign 10 vendors for simplicity
            ->limit(10)
            ->all();

        $categories = $query_categories->orderBy('Name') //fetching the categories
            ->all();

        //fetching coupons from db
        $coupons = $query_coupons
            ->orderBy('CouponID')
            ->with('website')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        //sending all the objects to the view file for rendering
        return $this->render('index', [
                'coupons' => $coupons,
                'pagination' => $pagination,
                'vendors' => $vendors,
                'categories' => $categories
        ]);
    }

    public function actionOffers($choice, $vendor_id, $category_id)
    {
        /*
         * Description about arguments
         * $choice : 1 for coupon , 2 for deal and 3 for coupon+deal
         * $vendor_id : Either "Allvendors or vendorid
         * $category_id : Either "Allcategories or category_id
         * Designed to return the ajax calls made from VIEW
         */

        $request = Yii::$app->request;

        if ($request->isAjax) { //checking whether the request is ajax or not
            //$data = Yii::$app->getRequest()->getBodyParam('data');
            //var_dump($category_id);
            $coupons = Coupon::getCouponsBasedOnTypeVendorCategory($choice, $vendor_id, $category_id);

            return $this->renderAjax('offers', ['coupons' => $coupons]);
            //return json_encode(['status' => 'SUCCESS', 'coupons' => $coupons]); for reference purpose
        }
    }

    public function actionExcelcoupons($choice, $vendor_id, $category_id)
    {
        /*
         * Description about arguments
         * $choice : 1 for coupon , 2 for deal and 3 for coupon+deal
         * $vendor_id : Either "Allvendors or vendorid
         * $category_id : Either "Allcategories or category_id
         * Designed to return the ajax calls made from VIEW
         */

        $coupons = Coupon::getCouponsBasedOnTypeVendorCategory($choice, $vendor_id, $category_id);

        $objPHPExcel = new \PHPExcel(); //make a new object of the php excel

        $sheet = 0; //start on sheet zero

        $objPHPExcel->setActiveSheetIndex($sheet);

        $row = 2; //start from 2nd row
        //making 4 columns
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

        //setting titles on 1st row
        $objPHPExcel->getActiveSheet()->setTitle('Coupons Excel Sheet')
            ->setCellValue('A1', 'CouponID')
            ->setCellValue('B1', 'CouponCode')
            ->setCellValue('C1', 'VendorID')
            ->setCellValue('D1', 'Coupon Title');
        foreach ($coupons as $coupon) {

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $coupon->CouponID);

            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $coupon->CouponCode);

            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $coupon->WebsiteID);

            if ($coupon->Title != NULL) { //as all coupons don't have titles
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $coupon->Title);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, substr($coupon->Description, 0, 20));
            }

            $row++; //incrementing row
        }

        //default header type has to assign
        header('Content-Type: application/vnd.ms-excel');

        $filename = "CouponData.xlsx"; //filename of the downloaded excel sheet

        header('Content-Disposition: attachment;filename=' . $filename . ' ');

        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objWriter->save('php://output'); //getting output

        exit();
    }
}
