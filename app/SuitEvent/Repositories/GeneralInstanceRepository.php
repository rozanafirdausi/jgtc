<?php

namespace App\SuitEvent\Repositories;

use Carbon\Carbon;
use Suitcore\Repositories\SuitRepository;

class GeneralInstanceRepository extends SuitRepository
{
    // Volunteer
    public function getVolunteerRegistrationLink($email, $fullName = "", $cityCode = "", $isMember = false)
    {
        if ($isMember) { // login page link
            $mainUrl = "https://www.goaheadpeople.id/user/login/volunteer/soundrenaline?link=";
            $string = "email=" . $email;
        } else { // register page link
            $mainUrl = "https://www.goaheadpeople.id/user/register/volunteer/soundrenaline?link=";
            $string = "fullname=" . $fullName . "&email=" . $email . "&cityCode=" . $cityCode;
        }
        $encKey = "YongUonhanJumALida567812345677";
        $encryptParam = "";
        if ($string != "" && $string != null) {
            $encryptParam = base64_encode(
                mcrypt_encrypt(
                    MCRYPT_RIJNDAEL_256,
                    md5($encKey),
                    $string,
                    MCRYPT_MODE_CBC,
                    md5(md5($encKey))
                )
            );
        }
        return $mainUrl . $encryptParam;
    }

    // Project
    public function getProjectRegistrationLink($projectName)
    {
        $mainUrl = "https://www.goaheadpeople.id/user/login/volunteer/soundrenaline?link=";
        $string = "email=&project=" . $projectName;
        $encKey = "YongUonhanJumALida567812345677";
        $encryptParam = "";
        if ($string != "" && $string != null) {
            $encryptParam = base64_encode(
                mcrypt_encrypt(
                    MCRYPT_RIJNDAEL_256,
                    md5($encKey),
                    $string,
                    MCRYPT_MODE_CBC,
                    md5(md5($encKey))
                )
            );
        }
        return $mainUrl . $encryptParam;
    }

    // ORDER
    public static function generateOrderCode($prefix = 'SMS')
    {
        $timestamps = Carbon::now()->format('Y-m-d');
        $date = Carbon::now()->format('ymd');
        $hour = Carbon::now()->format('H');
        $countData = Order::where('created_at', 'like', $timestamps . '%')->count();
        $code = $prefix . $date . str_pad(++$countData, 4, '0', STR_PAD_LEFT) . $hour;

        return $code;
    }

    // INVOICE
    public static function generateInvoiceCode($prefix = 'INV')
    {
        $timestamps = Carbon::now()->format('Y-m-d');
        $date = Carbon::now()->format('ymd');
        $countData = CustomerInvoice::where('created_at', 'like', $timestamps . '%')->count();
        $code = $prefix . '/' . $date . '/' . str_pad(++$countData, 5, '0', STR_PAD_LEFT);

        return $code;
    }

    // LPH
    public static function generateLphCode($prefix = 'LPHSM')
    {
        $timestamps = Carbon::now()->format('Y-m-d');
        $date = Carbon::now()->format('ymd');
        $countData = LaporanPenerimaanHarian::where('created_at', 'like', $timestamps . '%')->count();
        $code = $prefix . '-' . $date . '-' . str_pad(++$countData, 5, '0', STR_PAD_LEFT);

        return $code;
    }

    // LPH
    public static function generateBmCode($prefix = 'BMSM')
    {
        $timestamps = Carbon::now()->format('Y-m-d');
        $date = Carbon::now()->format('ymd');
        $countData = BuktiKasMasuk::where('created_at', 'like', $timestamps . '%')->count();
        $code = $prefix . '-' . $date . '-' . str_pad(++$countData, 5, '0', STR_PAD_LEFT);

        return $code;
    }

    /**
     * Generate unique payment code
     * @param int $paymentMethodId
     * @return string|null
     */
    public function generatePaymentCode($paymentMethodId)
    {
        $payment = PaymentMethod::find($paymentMethodId);
        if ($payment && $payment->type == PaymentMethod::TRANSFER) {
            $randomNumber = rand(1000, 10000) % settings('payment_code_maximum_number', 999);
            if ($randomNumber == 0) {
                $this->generatePaymentCode($paymentMethodId);
            } else {
                $paymentCode = str_pad($randomNumber, 3, '0', STR_PAD_LEFT);
                return $paymentCode;
            }
        }
        return null;
    }

    // PRODUCT
    public static function generateProductSku($productId, $prefix = 'SM')
    {
        $product = Product::find($productId);
        if ($product) {
            // Get Parent Category
            $productCategory = $product->category;
            $parentCategory = null;
            if ($productCategory) {
                $parentCategory = $productCategory->parent;
                if ($parentCategory == null) {
                    $parentCategory = $productCategory;
                }
            }
            $secondPartCode = $parentCategory && $parentCategory->code ? $parentCategory->code : 'XX';
            $thirdPartCode = $productCategory && $productCategory->code ? $productCategory->code : 'YYY';
            $subCategoryCode = $prefix . $secondPartCode . $thirdPartCode;

            $lastSimilarProduct = Product::where('sku', 'like', $subCategoryCode . '%')
                                         ->orderBy('sku', 'desc')
                                         ->first();
            if ($lastSimilarProduct) {
                $lastProductEndCode = substr($lastSimilarProduct->sku, -4);
                $fourthPartCode = str_pad($lastProductEndCode + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $fourthPartCode = str_pad(1, 4, '0', STR_PAD_LEFT);
            }

            $fullCode = $subCategoryCode . $fourthPartCode;
            return $fullCode;
        }
        return null;
    }

    /**
     * Generate lowest installment
     * @param  double $totalPrice ex: IDR 550000
     * @param  integer $tenor ex: 12 month
     * @param  double $interest ex: 0.75%
     * @return double
     */
    public function generateLowestInstallmentOfProduct($totalPrice, $tenor, $interest)
    {
        return ceil(( $totalPrice + ($tenor * $interest / 100 * $totalPrice) ) / $tenor);
    }

    public function generatePromotionPrice($promoType, $promoAmount, $originalPrice = 0)
    {
        if ($promoType == Product::PERCENT) {
            return (($promoAmount * $originalPrice) / 100);
        } elseif ($promoType == Product::NOMINAL) {
            return $promoAmount;
        }
        return 0;
    }

    public function getDppPrice($currentPrice)
    {
        return round($currentPrice / 1.1);
    }

    public function getPpnPrice($dppPrice)
    {
        return round($dppPrice * 0.1);
    }

    public function getDpAmount($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $productCategory = $product->category;
            if ($product->booking_price_percentage != null) {
                return $product->booking_price_percentage . '%';
            } elseif ($productCategory &&
                      $productCategory->extended &&
                      $productCategory->extended->dp_type != null
                ) { // DP setting in category_extensions table
                $extendedCategory = $productCategory->extended;
                if ($extendedCategory->dp_type == Product::PERCENT) {
                    return $extendedCategory->dp_amount . '%';
                } elseif ($extendedCategory->dp_type == Product::NOMINAL) {
                    return asCurrency($extendedCategory->dp_amount);
                }
            } elseif ($productCategory->parent &&
                      $productCategory->parent->extended &&
                      $productCategory->parent->extended != null
                ) { // DP setting in parent category_extensions table
                $extendedParentCategory = $productCategory->parent->extended;
                if ($extendedParentCategory->dp_type == Product::PERCENT) {
                    return $extendedParentCategory->dp_amount . '%';
                } elseif ($extendedParentCategory->dp_type == Product::NOMINAL) {
                    return asCurrency($extendedParentCategory->dp_amount);
                }
            }
        }
        return null;
    }

    // CATEGORY
    public static function generateChildCategoryCode($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category && $category->parent) {
            $countData = Category::where('parent_id', $category->parent_id)
                                 ->whereNotIn('id', [$category->id])
                                 ->count();
            $childCode = str_pad($countData + 1, 3, '0', STR_PAD_LEFT);
            return $childCode;
        }
        return null;
    }
}
