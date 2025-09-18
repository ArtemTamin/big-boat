<?php
/**
* @package Joomla
* @subpackage JoomShopping
* @author Garry
* @website https://joom-shopping.com
* @email info@joom-shopping.com
* @license Gnu Gpl v3
**/

defined('_JEXEC') or die;
?>
<div class="jshop">
	<div id="error_min_max_price_order" <?php if ($this->min_price_order || $this->max_price_order) { ?>class="text-danger"<?php } ?>>
		<?php
		if ($this->min_price_order) {
			printf(_JSHOP_ERROR_MIN_SUM_ORDER, formatprice($this->min_price_order * $this->config->currency_value));
		}
		if ($this->max_price_order) {
			printf(_JSHOP_ERROR_MAX_SUM_ORDER, formatprice($this->max_price_order * $this->config->currency_value));
		}
		?>
	</div>

	<div class="basket__product-info info-product">
                <div class="info-product__head">
                    <div class="info-product__empty-block"></div>
                    <div class="info-product__head-titles">
                        <div class="item-first"><?php print _JSHOP_ITEM ?></div>
                        <div class="item"><?php print _JSHOP_SINGLEPRICE ?></div>
                        <div class="item"><?php print _JSHOP_NUMBER ?></div>
                        <div class="item"><?php print _JSHOP_PRICE_TOTAL ?></div>
                        <div class="item"></div>
                    </div>
                </div>
                <?
//                    $cart = JModelLegacy::getInstance('cart', 'jshop');
//                    $cart->load("cart");
					$arrProductsPB = [];
                    $products = $this->products;
                    $arrProducts = [
                        'shopCode' => '461',
                        'regCode' => '76',
						"promoCode" => "ed9-installment_0_0_6",
                        'sum' => (float) $this->fullsumm,
                    ];
                    foreach ($products as $product) {
						$arrProductsPB[] = [
								'category' =>'262',
								'model' =>(string)$product['product_name'],
							 	'mark' =>'товар big-boat',
								'quantity' =>(int)$product['quantity'],
								'price' =>(float)$product['price'],
							];
                        $arrProducts['items'][] = [
							'name' => (string)$product['product_name'],
                            'quantity' => (int)$product['quantity'],
                            'price' => (float)$product['price'],
                        ];
                    }


                    $result = json_encode($arrProducts, JSON_UNESCAPED_UNICODE);
					$pochtaBank = json_encode($arrProductsPB, JSON_UNESCAPED_UNICODE);
                ?>

        <script>
            $(document).ready(function () {
                let postUrl = 'https://api.mtsbank.ru/online-stores-pos/v1/applications';
                let data = <?= $result?>;
                $(".MTS").on('click', function(){
                    var settings = {
                        "url": postUrl,
                        "method": "POST",
                        "timeout": 0,
                        "headers": {
                            "Content-Type": "application/json",
                            "Client-id": "online-stores-pos"
                        },
                        "data": JSON.stringify(data),
                    };

                    $.ajax(settings).done(function (response) {
                        window.open(response.applicationLink, "_blank");
						return false;
                    }).fail(function(e) {
                        console.log( e.responseJSON); // выводим в консоль параметры
                    });
                });

				// console.log(data)
				// $(".MTSS").on('click', function(){
                //     $.ajax({
				// 		url: '/api', // Укажите путь к вашему PHP-скрипту
				// 		method: 'POST',
				// 		data: { data: data },
				// 		success: function(response) {
				// 			try {
				// 				let jsonResponse = JSON.parse(response);
				// 				if (jsonResponse.applicationLink) {
				// 					window.open(jsonResponse.applicationLink, "_blank");
				// 				} else {
				// 					console.log('Error:', jsonResponse);
				// 				}
				// 			} catch (e) {
				// 				console.log('Invalid JSON response:', response);
				// 			}
				// 		},
				// 		error: function(e) {
				// 			console.log('AJAX error:', e);
				// 		}
				// 	});
				// 	return false;
                // });

            });
        </script>

		<script src="https://my.pochtabank.ru/sdk/v2/pos-credit.js"></script>
		<script>
		$(document).ready(function () {
			var pb = <?= $pochtaBank?>;
			
			let p = <?=$result?>;
			let sk = '12,24,36';
			let sr = '6';
			let z = uuidv4();
			let m = 'Товары для рыбной ловли';
			console.log('тип данных ' + p.sum);

			var options = {
				operId: uuidv4(), // id операции
				productCode:'EXP_MP_PP_23,9', //  Код продукта 1-го уровня 
				amountCredit: '', // Сумма кредита. Опционально
				termCredit: '6',
				firstPayment:2000 ,// Сумма первоначального взноса
				ttCode: '0702001010081', // Код торговой точки. Обязательно
				ttName: '', // Текст в поле пункт выдачи товара.
				toCode: '070200101008', // Идентификатор ТО
				fullName: '',  // ФИО. Опционально
				phone: '',     // Телефон в формате 9161232323. Опционально
				brokerAgentId: 'NON_BROKER', // В этом поле может передаваться Id сотрудника Банка, с префиксом PB*
				order: pb,
			};
			$('#pos-credit-link').attr('href', 'https://onlypb.pochtabank.ru/bigboat?p='+p.sum+'&sk='+sk+'&sr='+sr+'&z='+z+'&m='+m);


			function uuidv4() {
				return 'xxxxxxxx'.replace(/[xy]/g, function (c) {
					var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
					return v.toString(16);
				});
			}
		});
		</script>
                <?php
                $i = 1;
				
                foreach ($this->products as $key_id => $prod) {
                    ?>

                    <div class="info-product__body">
                        <!--                            <div class="info-product__img" -->
                        <?php //if ($i % 2 == 0) print "even"; else print "odd" ?><!--"></div>-->
                        <div class="info-product__img">
                            <a href="<?php print $prod['href'] ?>">
                                <img src="<?php print $this->image_product_path ?>/<?php if ($prod['thumb_image']) print $prod['thumb_image']; else print $this->no_image; ?>"
                                     alt="<?php print htmlspecialchars($prod['product_name']); ?>"
                                     class="jshop_img"/>
                            </a>
                            <div class="item item-delete-mobile">
							<a href="<?php echo SEFLink('index.php?option=com_jshopping&controller=cart&task=delete&number_id='.$key_id, 1)?>" onclick="if(confirm('<?php echo JText::_("JSHOP_ONESTEPCHECKOUT_CONFIRM_REMOVE") ?>')){jQuery('#quantity<?php echo $key_id ?>').val(0);oneStepCheckout.refreshForm()}return false;" title = "<?php echo JText::_("JSHOP_ONESTEPCHECKOUT_REMOVE") ?>">x</a>
                            </div>

                        </div>
                        <div class="info-product__info">
                            <div class="item-first">
                                <a href="<?php print $prod['href'] ?>">
                                    <?php print $prod['product_name'] ?>
                                </a>
                                <?php if ($this->config->show_product_code_in_cart) { ?>
                                    <span class="jshop_code_prod">
                                            (<?php print $prod['ean'] ?>)
                                        </span>
                                <?php } ?>
                                <?php if ($prod['manufacturer'] != '') { ?>
                                    <div class="manufacturer"><?php print _JSHOP_MANUFACTURER ?>:
                                        <span>
                                                <?php print $prod['manufacturer'] ?>
                                            </span>
                                    </div>
                                <?php } ?>
                                <?php print sprintAtributeInCart($prod['attributes_value']); ?>
                                <?php print sprintFreeAtributeInCart($prod['free_attributes_value']); ?>
                                <?php print sprintFreeExtraFiledsInCart($prod['extra_fields']); ?>
                                <?php print $prod['_ext_attribute_html'] ?>
                            </div>
                            <div class="item item-price">
                                <?php print formatprice($prod['price']) ?>
                                <?php print $prod['_ext_price_html'] ?>
                                <?php if ($this->config->show_tax_product_in_cart && $prod['tax'] > 0) { ?>
                                    <span class="taxinfo">
                                        <?php print productTaxInfo($prod['tax']); ?>
                                    </span>
                                <?php } ?>
                                <?php if ($this->config->cart_basic_price_show && $prod['basicprice'] > 0) { ?>
                                    <div class="basic_price"><?php print _JSHOP_BASIC_PRICE ?>:
                                        <span>
                                            <?php print sprintBasicPrice($prod); ?>
                                        </span>
                                    </div>
                                <?php } ?>
                            </div>
                            <span class="item">

                                    <!--дефолтный счетчик-->

                                <!--                                    --><?php //print formatprice($prod['price']) ?>
<!--                                --><?php //print $prod['_ext_price_html'] ?>
<!--                                --><?php //if ($this->config->show_tax_product_in_cart && $prod['tax'] > 0) { ?>
<!--                                    <span class="taxinfo">-->
                                <?php //print productTaxInfo($prod['tax']); ?><!--</span>-->
                                <!--                                --><?php //} ?>
<!--                                --><?php //if ($this->config->cart_basic_price_show && $prod['basicprice'] > 0) { ?>
<!--                                    <div class="basic_price">--><?php //print _JSHOP_BASIC_PRICE ?><!--: <span>-->
                                <?php //print sprintBasicPrice($prod); ?><!--</span></div>-->
                                <!--                                --><?php //} ?>
<!---->
                                <!--                                    <input type="number" name="quantity[-->
                                <?php //print $key_id ?><!--]" min="0"-->
                                <!--                                           value="-->
                                <?php //print $prod['quantity'] ?><!--" class="inputbox"-->
                                <!--                                           style="width: 25px"-->
                                <!--                                    />-->
                                <!--                                    --><?php //print $prod['_qty_unit']; ?>
<!--                                    <span class="cart_reload">-->
                                <!--                                      <img style="cursor:pointer" src="-->
                                <?php //print $this->image_path ?><!--/images/bs/reload.png"-->
                                <!--                                           title="-->
                                <?php //print _JSHOP_UPDATE_CART ?><!--" alt="-->
                                <?php //print _JSHOP_UPDATE_CART ?><!--"-->
                                <!--                                           onclick="document.updateCart.submit();"/>-->
                                <!--                                    </span>-->

                                <!--кастомный счетчик-->
                                    <div class="basket__product-count">
									<div class="quantity">
						<span class="quantitymore" onclick="qty=jQuery('#quantity<?php echo $key_id ?>');qty.val(parseFloat(qty.val())+1);qty.change()"></span>
						<input type="text" id="quantity<?php echo $key_id ?>" name="quantity[<?php echo $key_id ?>]" value="<?php echo $prod['quantity'] ?>" data-quantity="<?php echo $prod['quantity'] ?>" onkeyup="oneStepCheckout.refreshForm(this,800)" onchange="oneStepCheckout.refreshForm(this,0)" />
						<span class="quantityless" onclick="qty=jQuery('#quantity<?php echo $key_id ?>');qty.val(parseFloat(qty.val())-1);qty.change()"></span>
					</div>
					<?php echo $prod['_qty_unit'] ?>
                                    </div>
                                </span>
                            <span class="item item-total-price">
                                    <?php print formatprice($prod['price'] * $prod['quantity']); ?>
                                <?php print $prod['_ext_price_total_html'] ?>
                                <?php if ($this->config->show_tax_product_in_cart && $prod['tax'] > 0) { ?>
                                    <span class="taxinfo"><?php print productTaxInfo($prod['tax']); ?></span>
                                <?php } ?>
                                </span>
                            <div class="item item-delete">
							<a href="<?php echo SEFLink('index.php?option=com_jshopping&controller=cart&task=delete&number_id='.$key_id, 1)?>" onclick="if(confirm('<?php echo JText::_("JSHOP_ONESTEPCHECKOUT_CONFIRM_REMOVE") ?>')){jQuery('#quantity<?php echo $key_id ?>').val(0);oneStepCheckout.refreshForm()}return false;" title = "<?php echo JText::_("JSHOP_ONESTEPCHECKOUT_REMOVE") ?>">x</a>
                            </div>
                        </div>

                    </div>

                    <?php
                    $i++;
                }
                ?>
            </div>

            <?php if ($this->config->show_weight_order) { ?>
                <div class="weightorder">
                    <?php print _JSHOP_WEIGHT_PRODUCTS ?>: <span><?php print formatweight($this->weight); ?></span>
                </div>
            <?php } ?>

            <?php if ($this->config->summ_null_shipping > 0) { ?>
                <div class="shippingfree">
                    <?php printf(_JSHOP_FROM_PRICE_SHIPPING_FREE, formatprice($this->config->summ_null_shipping, null, 1)); ?>
                </div>
            <?php } ?>

            <div class="basket__subtotal">
                <div class="basket__subtotal-row">
					
				
                </div>
            </div>
	<?php if ($this->config->show_weight_order){ ?>  
	<div class="weightorder">
		<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_WEIGHT_PRODUCTS') ?>: <span><?php echo formatweight($this->weight);?></span>
	</div>
	<?php }?>
<div class="df">
	<div class="continue_shopping">
		<a href="/dingh" class="basket__btn-next">Продолжить покупки</a>
	</div>
	<table class = "jshop jshop_subtotal">
		<tr>
			<td class="name">
				<strong>В корзине:</strong> 
			</td>
			<td class="value">
				<?php 
					$position = '';

					if(count($this->products) === 1){
						$position = " позиция";
					}elseif (count($this->products) > 1 && count($this->products) <= 4) {
						$position = " позиции";
					}elseif (count($this->products) > 4) {
						$position = " позиций";
					}
				
				
				?>
				<?php echo count($this->products) . $position; ?> 

			</td>
		</tr>
		<?php if (!$this->hide_subtotal){?>
		
		<?php } ?>
		<?php if ($this->discount > 0){ ?>
		<tr class="preview_discount">
			<td class="name">
				<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_RABATT_VALUE') ?>
			</td>
			<td class="value">
				<?php echo formatprice(-$this->discount) ?>
				<?php echo $this->_tmp_ext_discount ?>
			</td>
		</tr>
		<?php } ?>

		<?php if (isset($this->summ_package)){?>
		<tr>
			<td class="name">
				<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_PACKAGE_PRICE') ?>
			</td>
			<td class="value">
				<?php echo formatprice($this->summ_package) ?>
				<?php echo $this->_tmp_ext_shipping_package ?>
			</td>
		</tr>
		<?php } ?>
		<?php if ($this->summ_payment != 0){ ?>
		<tr>
			<td class="name">
				<?php echo $this->payment_name ?>
			</td>
			<td class="value">
				<?php echo formatprice($this->summ_payment) ?>
				<?php echo $this->_tmp_ext_payment ?>
			</td>
		</tr>
		<?php } ?>  
		<?php if (!$this->config->hide_tax){ ?>
		<?php foreach($this->tax_list as $percent=>$value){ ?>
		<tr>
			<td class="name">
				<?php echo displayTotalCartTaxName() ?>
				<?php if ($this->show_percent_tax) echo formattax($percent)."%" ?>
			</td>
			<td class="value">
				<?php echo formatprice($value) ?>
				<?php echo $this->_tmp_ext_tax[$percent] ?>
			</td>
		</tr>
		<?php } ?>
		<?php } ?>
		<tr class="total">
			<td class="name">
				Сумма:
			</td>
			<td class="value">
				<?php echo formatprice($this->fullsumm) ?>
				<?php echo $this->_tmp_ext_total ?>
			</td>
		</tr>
		<?php if ($this->free_discount > 0){ ?>  
		<tr class="one-step-discount">
			<td colspan="2" align="right">    
				<span class="free_discount"><?php echo JText::_('JSHOP_ONESTEPCHECKOUT_FREE_DISCOUNT') ?>: <?php echo formatprice($this->free_discount) ?></span>  
			</td>
		</tr>
		<?php }?>  
	</table>
</div>
	<p class="delivery_finish">
				В сумму заказа не включена стоимость доставки
			</p>
	<?php if ($this->config->use_rabatt_code){ ?>
		<div class="rabatt_input">
			<?php if (!$this->addonParams->placeholder) { ?>
			<div class=" os-name">
				<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_RABATT_INPUT') ?> 
			</div>
			<?php } ?>
			<div class="input-append">
				<input type="text" name="rabatt" <?php if ($this->addonParams->placeholder) { ?>placeholder="<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_RABATT_INPUT') ?>"<?php } ?> value="" />
				<input type="button" class="uk-button" value="<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_RABATT_ACTIVE') ?>" onclick="oneStepCheckout.rabbatForm()" />
			</div>
		</div>
	<?php } ?>
</div>
<div>
	Для окончательного оформления Вашего заказа необходимо заполнить ниже представленную форму. По указанным контактным данным с Вами свяжется наш менеджер и поможет в подборе подходящей транспортной компании и сообщит его общую стоймость 
</div>
<br/>