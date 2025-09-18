<?php
defined('_JEXEC') or die();
$countprod = count($this->products);
?>
<div class="container">
    <div class="basket">
        <div class="basket__head">
            <h2 class="basket__title"><?php print _JSHOP_YOUR_CART ?></h2>
            <div class="basket__next-shop" width="100%">
                <div class="basket__in-basket">
                    В корзине:
                    <span class="basket__count-product">

                    </span>
                </div>
                <div class="basket__price">
                    На сумму:
                    <span class="basket__total-price-head">
                        <?php print formatprice($this->summ); ?><?php print $this->_tmp_ext_subtotal ?>
                    </span>
                </div>
                <a href="/dingh" class="basket__btn-next">Продолжить покупки</a>
            </div>
        </div>

        <form action="<?php print SEFLink('index.php?option=com_jshopping&controller=cart&task=refresh') ?>"
              method="post"
              name="updateCart">
            <?php print $this->_tmp_ext_html_cart_start ?>
            <?php if ($countprod > 0) { ?>

            <div class="basket__product-info info-product">
                <div class="info-product__head">
                    <div class="info-product__empty-block"></div>
                    <div class="info-product__head-titles">
                        <div class="item-first"><?php print _JSHOP_ITEM ?></div>
                        <div class="item"><?php print _JSHOP_SINGLEPRICE ?></div>
                        <div class="item"><?php print _JSHOP_NUMBER ?></div>
                        <div class="item"><?php print _JSHOP_PRICE_TOTAL ?></div>
                        <div class="item"><?php print _JSHOP_REMOVE ?></div>
                    </div>
                </div>

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
                                <a href="<?php print $prod['href_delete'] ?>" data_del="del"
                                   onclick="return confirm('<?php print _JSHOP_CONFIRM_REMOVE ?>')"><img
                                            src="<?php print $this->image_path ?>images/bs/remove-mobile.png"
                                            alt="<?php print _JSHOP_DELETE ?>"
                                            title="<?php print _JSHOP_DELETE ?>"/></a>
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
                                        <div class="basket__product-count-btn">
                                            <button class="quantity-arrow-minus"> -</button>
                                            <input class="quantity-num"
                                                   type="number"
                                                   value="<?php print $prod['quantity'] ?>"
                                                   min="0"
                                                   name="quantity[<?php print $key_id ?>]"

                                            />
                                            <button class="quantity-arrow-plus"> +</button>
                                        </div>

                                                                                <?php print $prod['_qty_unit']; ?>
                                        <span class="cart_reload">
                                            <img style="cursor:pointer"
                                                 src="<?php print $this->image_path ?>/images/bs/reload.png"
                                                 title="<?php print _JSHOP_UPDATE_CART ?>"
                                                 alt="<?php print _JSHOP_UPDATE_CART ?>"
                                                 onclick="document.updateCart.submit();"/>
                                        </span>
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
                                <a href="<?php print $prod['href_delete'] ?>" data_del="del"
                                   onclick="return confirm('<?php print _JSHOP_CONFIRM_REMOVE ?>')"><img
                                            src="<?php print $this->image_path ?>images/bs/remove-mobile.png"
                                            alt="<?php print _JSHOP_DELETE ?>"
                                            title="<?php print _JSHOP_DELETE ?>"/></a>
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
                    <a href="/dingh" class="basket__btn-next">Продолжить покупки</a>
                    <ul>

                        <?php if (!$this->hide_subtotal) { ?>
                            <li>
                                <div class="length">В корзине: <span style="font-weight: bold;"
                                                                     class="length"></span></div>
                                <span class="name"><?php print _JSHOP_SUBTOTAL ?>:</span>
                                <span class="value"><?php print formatprice($this->summ); ?><?php print $this->_tmp_ext_subtotal ?></span>
                            </li>
                        <?php } ?>
                        <?php if ($this->discount > 0) { ?>
                            <li>
                                <div class="length">В корзине: <span style="font-weight: bold;"
                                                                     class="length"></span></div>
                                <span class="name"><?php print _JSHOP_RABATT_VALUE ?>:</span>
                                <span class="value"><?php print formatprice(-$this->discount); ?><?php print $this->_tmp_ext_discount ?></span>
                            </li>
                        <?php } ?>
                        <?php if (!$this->config->hide_tax) { ?>
                            <?php foreach ($this->tax_list as $percent => $value) { ?>
                                <li>
                                    <div class="length">В корзине: <span style="font-weight: bold;"
                                                                         class="length"></span>
                                    </div>
                                    <span class="name"><?php print displayTotalCartTaxName(); ?>
                                        <?php if ($this->show_percent_tax) print formattax($percent) . "%" ?>:</span>
                                    <span class="value"><?php print formatprice($value); ?><?php print $this->_tmp_ext_tax[$percent] ?></span>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <li>
                            <div class="length">Ваш заказ: <span style="font-weight: bold;" class="length"></span>
                            </div>
                            <span class="name">на сумму: </span>
                            <span style="font-weight: bold;"
                                  class="value"><?php print formatprice($this->fullsumm) ?><?php print $this->_tmp_ext_total ?></span>
                            <?php if ($this->config->show_plus_shipping_in_product) { ?>
                                <br/><span
                                        class="plusshippinginfo">В сумму заказа не включена стоймость доставки</span>
                            <?php } ?>
                        </li>

                        <?php if ($this->free_discount > 0) { ?>
                            <div calss="text-right">
                                <span class="free_discount"><?php print _JSHOP_FREE_DISCOUNT; ?>: <?php print formatprice($this->free_discount); ?></span>
                            </div>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </form>

        <div class="basket__description-delivery">
            <div class="cartdescr"><?php print $this->cartdescr ?></div>
            <br/>
            <?php } else { ?>
                <div class="cart_empty_text"><?php print _JSHOP_CART_EMPTY ?></div>
            <?php } ?>

            <div class="checkout" id="checkout">
                <div class="btn-group">

                    <?php if ($countprod > 0) { ?>
                        <a class="btn btn-issue" href="<?php print $this->href_checkout ?>&Itemid=153">
                            <?php print _JSHOP_CHECKOUT ?>
                            <!--<i class="icon-arrow-right"></i>-->
                        </a>
                        <div class="basket__btn-rassrochka" style="position:relative">
                            <div class="btn rassrochka cart">Оформить рассрочку</div>
                        </div>
                    <?php } ?>

                    <style>
                        .d-none {
                            display: none;
                        }

                        #pos-credit-container {
                            z-index: 9999;
                        }
                    </style>
                </div>

                <!--Виджет v1 asdasdadas-->
                <!--<script src="https://my.pochtabank.ru/sdk/v1/pos-credit.js"></script>

                <script>
                    let container = document.getElementById('pos-credit-container');
                    let rassrochka = document.querySelector('.rassrochka');
                    rassrochka.addEventListener('click', () => {
                        container.classList.toggle('d-none');
                    });
                    var options = {
                        ttCode: '0702001010081',
                        ttName: 'Г. КИРОВ',
                        fullName: '',
                        phone: '',
                        category: '262',
                        manualOrderInput: true
                    };
                    window.PBSDK.posCredit.mount('#pos-credit-container', options);
                    // подписка на событие завершения заполнения заявки
                    window.PBSDK.posCredit.on('done', function (id) {
                        console.log('Id заявки: ' + id)
                    });
                    // При необходимости можно убрать виджет вызвать unmount
                    // window.PBSDK.posCredit.unmount('#pos-credit-container');
                </script>-->

                <!--Виджет v2-->
                    
                <link href="https://onlypb.pochtabank.ru/PBstyles.css" rel=stylesheet type="text/css">

                <div class="PBnkBox d-none">
                    <div class="PBnkHead">
                        <div class="PBnkLogo"></div>
                        <div class="PBnkTitle">Биг Боут<br>Заявка в банк</div>
                        <div style="clear:both;"></div>
                    </div>

                    <div class="PBnkForm">
                        <div class="PBnkLine">Укажите</div>
                        <input type="number" class="PBnkInput" required id="chekPrice" placeholder="Стоимость товара"
                               title="От 3 до 300 тысяч рублей"/>
                        <div style="clear:both;"></div>
                    </div>

                    <div class="PBnkForm">
                        <div class="PBnkLine">Срок</div>
                        <select id="termCredit" class="PBnkSelect">
                            <option value="66">Рассрочка 6 месяцев</option>
                            <option value="12">Кредит 12 месяцев</option>
                            <option value="18">Кредит 18 месяцев</option>
                            // срок кредита
                            <option value="24" selected>Кредит 24 месяца</option>
                            <option value="36">Кредит 36 месяцев</option>
                        </select>
                        <div style="clear:both;"></div>
                    </div>

                    <div class="PBnkForm">
                        <div class="PBnkLine">Укажите</div>
                        <input type="number" class="PBnkInput" required id="firstPayment"
                               placeholder="Первоначальный взнос" title="До 40% от стоимости товара"/>
                        <div style="clear:both;"></div>
                    </div>

                    <button class="PBnkButton" onClick="credit_form()">Перейти к оформлению заявки</button>
                </div>
                <div id="pos-credit-container"></div>
                <script src="https://my.pochtabank.ru/sdk/v2/pos-credit.js"></script>

                <script>
                    let container = document.querySelector('.PBnkBox');
                    let rassrochka = document.querySelector('.rassrochka');
                    rassrochka.addEventListener('click', () => {
                        container.classList.toggle('d-none');
                    });

                    function uuidv4() {
                        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                            return v.toString(16);
                        });
                    }

                    function credit_form() {
                        var chekPrice = $('#chekPrice').val();
                        var termCredit = $('#termCredit').val();
                        var firstPayment = $('#firstPayment').val();
                        var productCode = $('#productCode').val();

                        var ttName = "Биг Боут";
                        var email = "big-boat@yandex.ru, urvantsevms2@pochtabank.ru";
                        var operId = uuidv4();
                        var srok = termCredit;
                        var chekprice2 = chekPrice - firstPayment;


                        var amountCredit = chekPrice - firstPayment;
                        var firstPaymentMax = chekPrice * 0.4;

                        if (amountCredit > 300000 || amountCredit < 3000 || amountCredit == '') {
                            alert("Сумма кредита должна быть не менее 3'000 и не более 300'000 рублей");
                            return false;
                        }

                        if (firstPayment > firstPaymentMax) {
                            alert("Первый взнос должен быть не более 40% от суммы заявки");
                            return false;
                        }

                        if (firstPayment == '') {
                            var firstPayment = 0;
                        }

                        var chekprice2 = chekPrice - firstPayment;
                        var chekprice6 = chekprice2 * 0.950 + parseInt(firstPayment);
                        var chekprice12 = chekprice2 * 1 + parseInt(firstPayment);
                        var chekprice18 = chekprice2 * 1 + parseInt(firstPayment);
                        var chekprice24 = chekprice2 * 1 + parseInt(firstPayment);
                        var chekprice36 = chekprice2 * 1 + parseInt(firstPayment);
                        var productCode = 'EXP_MP_PP_+';

                        if (termCredit == 66) {
                            var chekPrice = parseInt(chekprice6);
                            var productCode = 'EXP_MP_PP_23,9';
                            var termCredit = '6';
                        } else if (termCredit == 1212) {
                            var chekPrice = parseInt(chekprice12);
                            var productCode = 'EXP_MP_PP_23,9';
                            var termCredit = '12';
                        } else if (termCredit == 1818) {
                            var chekPrice = parseInt(chekprice18);
                            var productCode = 'EXP_MP_PP_23,9';
                            var termCredit = '18';
                        } else if (termCredit == 2424) {
                            var chekPrice = parseInt(chekprice24);
                            var productCode = 'EXP_MP_PP_23,9';
                            var termCredit = '24';
                        } else if (termCredit == 3636) {
                            var chekPrice = parseInt(chekprice36);
                            var termCredit = '36';
                        }

                        var srok = termCredit;
                        var chekprice3 = chekPrice - firstPayment;

                        var options = {
                            operId: operId,
                            productCode: productCode, // код тарифа
                            ttCode: '0702001010081', // код ТТ
                            toCode: '070200101008', // код ТО
                            ttName: '', // адрес пункта выдачи товара
                            amountCredit: '',
                            termCredit: termCredit,
                            firstPayment: Number.parseInt(firstPayment),
                            fullName: '',
                            phone: '',
                            brokerAgentId: 'NON_BROKER',
                            returnUrl: '', //ссылка на страницу на которую возвращаемся после заполнения анкеты.
                            order: [{
                                category: '262',
                                mark: 'Лодка', // название товара или услуги
                                model: 'Лодка',  // название товара или услуги
                                quantity: 1, // количество
                                price: Number.parseInt(chekPrice), // Сумма заявки
                            }]
                        };

                        window.PBSDK.posCreditV2.mount('#pos-credit-container', options);
                        document.getElementById('pos-credit-container').scrollIntoView();
                        window.PBSDK.posCreditV2.on('done', function (id) {
                            var templateParams = {
                                e_site: ttName,
                                e_id: id,
                                e_summ: Number.parseInt(chekprice3),
                                e_srok: srok,
                                e_operid: operId,
                            };
                            emailjs.send('service_f147e9c', ' template_e13tj4p', templateParams);
                        });
                    }
                </script>

                <!--Виджет v2 конец-->


            </div>
        </div>
    </div>
</div>
<br/>
<br/>
<!-- <?php print $this->_tmp_ext_html_before_discount ?>
  <?php if ($this->use_rabatt && $countprod > 0) { ?>
  <form class="form-inline" name="rabatt" method="post" action="<?php print SEFLink('index.php?option=com_jshopping&controller=cart&task=discountsave') ?>">
        <?php print _JSHOP_RABATT ?>
        <input type = "text" class = "inputbox" name = "rabatt" value = "" />
        <input type = "submit" class = "btn" value = "<?php print _JSHOP_RABATT_ACTIVE ?>" />
  </form>
  <?php } ?>
</div> -->

