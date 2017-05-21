<?php
class StoreFront
{
public $mSiteUrl;
public $mContentsCell = 'first_page_contents.tpl';
public $mfirstCell = 'first.tpl';

public $mCategoriesCell = 'blank.tpl';
public $mCartSummaryCell = 'blank.tpl';
public $mLoginOrLoggedCell = 'customer_login.tpl';
public $mHideBoxes = false;
public $mTotalAmount;
public $mLinkToCartDetails;
// Class constructor
public $mPayPalContinueShoppingLink;
public function __construct()
{
$this->mSiteUrl = Link::Build('');
}
public function init()
{
$this->mTotalAmount = ShoppingCart::GetTotalAmount();
$this->mLinkToCartDetails = Link::ToCart();
$_SESSION['link_to_store_front'] =
Link::Build(str_replace(VIRTUAL_LOCATION, '', getenv('REQUEST_URI')));
// Build the "continue shopping" link
//if (!isset ($_GET['CartAction']))
//$_SESSION['link_to_last_page_loaded'] = $_SESSION['link_to_store_front'];
// Load department details if visiting a department
if (!isset ($_GET['CartAction']) && !isset($_GET['Logout']) &&
!isset($_GET['RegisterCustomer']) &&
!isset($_GET['AddressDetails']) &&
!isset($_GET['CreditCardDetails']) &&
!isset($_GET['AccountDetails']) &&
!isset($_GET['Checkout']) &&
!isset($_GET['CheckoutInfo'])
)
$_SESSION['link_to_last_page_loaded'] = $_SESSION['link_to_store_front'];
// Build the "cancel" link for customer details pages
if (!isset($_GET['Logout']) &&
!isset($_GET['RegisterCustomer']) &&
!isset($_GET['AddressDetails']) &&
!isset($_GET['CreditCardDetails']) &&
!isset($_GET['AccountDetails']) &&
!isset($_GET['CheckoutInfo'])
)
$_SESSION['customer_cancel_link'] = $_SESSION['link_to_store_front'];
if (isset ($_GET['DepartmentId']))
{
$this->mContentsCell = 'department.tpl';
$this->mCategoriesCell = 'categories_list.tpl';

}
elseif (isset($_GET['ProductId']) &&
isset($_SESSION['link_to_continue_shopping']) &&
strpos($_SESSION['link_to_continue_shopping'], 'DepartmentId', 0)
!== false)
{
$this->mCategoriesCell = 'categories_list.tpl';
}
// Load product details page if visiting a product
if (isset ($_GET['ProductId']))
$this->mContentsCell = 'product.tpl';
// Load search result page if we're searching the catalog
elseif (isset ($_GET['SearchResults']))
$this->mContentsCell = 'search_results.tpl';
if (isset ($_GET['CartAction']))
$this->mContentsCell = 'cart_details.tpl';
else
$this->mCartSummaryCell = 'cart_summary.tpl';
if (Customer::IsAuthenticated())
$this->mLoginOrLoggedCell = 'customer_logged.tpl';
if (isset ($_GET['RegisterCustomer']) ||
isset ($_GET['AccountDetails']))
$this->mContentsCell = 'customer_details.tpl';
elseif (isset ($_GET['AddressDetails']))
$this->mContentsCell = 'customer_address.tpl';
elseif (isset ($_GET['CreditCardDetails']))
$this->mContentsCell = 'customer_credit_card.tpl';
if (isset ($_GET['Checkout']))
{
if (Customer::IsAuthenticated())
$this->mContentsCell = 'customer_address.tpl';
else
$this->mContentsCell = 'checkout_not_logged.tpl';
$this->mHideBoxes = true;
}
if (isset($_GET['OrderDone']))
$this->mContentsCell = 'order_done.tpl';
elseif (isset($_GET['OrderError']))
$this->mContentsCell = 'order_error.tpl';

if (isset($_GET['OrderErrors']))
$this->mContentsCell = 'checkout_info.tpl';
if (isset($_GET['CheckoutInfo']))
$this->mContentsCell = 'checkout_info.tpl';
}



}
?>