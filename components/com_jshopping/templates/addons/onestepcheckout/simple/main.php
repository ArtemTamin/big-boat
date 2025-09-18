
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
if ($this->addonParams->step_number) {
    $step2number = $this->step2number . '. ';
    $step3number = $this->step3number . '. ';
    $step4number = $this->step4number . '. ';
    $step5number = $this->step5number . '. ';
} else {
    $step2number = $step3number = $step4number = $step5number = '';
}
if ($this->addonParams->step_name) {
    $step2name = JText::_('JSHOP_ONESTEPCHECKOUT_ADRESS_STEP');
    $step3name = $this->config->step_4_3 ? JText::_('JSHOP_ONESTEPCHECKOUT_SHIPPING_STEP') : JText::_('JSHOP_ONESTEPCHECKOUT_PAYMENT_STEP');
    $step4name = $this->config->step_4_3 ? JText::_('JSHOP_ONESTEPCHECKOUT_PAYMENT_STEP') : JText::_('JSHOP_ONESTEPCHECKOUT_SHIPPING_STEP');
    $step5name = JText::_('JSHOP_ONESTEPCHECKOUT_FINISH_STEP');
} else {
    $step2name = $step3name = $step4name = $step5name = '';
}
include __DIR__ . '/main.js.php';
if (file_exists(__DIR__ . '/custom.js.php')) {
    include __DIR__ . '/custom.js.php';
}
?>
<div id="step2errors"></div>
<div id="step3errors"></div>
<div id="step4errors"></div>
<?php
if ($this->addonParams->login_form && $this->config->shop_user_guest > 2 && $this->user->user_id == -1) {
    ?>
    <form id="oneStepLoginForm" name="oneStepLoginForm" class="form-inline"
          action="<?php echo SEFLink('index.php?option=com_jshopping&controller=user&task=loginsave', 1, 0, $this->config->use_ssl) ?>"
          method="post">
        <h3 class="js-login-title">
            <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_LOGIN_USER') ?>
        </h3>
        <?php if (!$this->addonParams->placeholder) { ?>
            <label for="username"><?php echo JText::_('JSHOP_ONESTEPCHECKOUT_USER_FIELD_U_NAME') ?></label>
        <?php } ?>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-user"></i></span>
            <input id="username" type="text" name="username"
                   <?php if ($this->addonParams->placeholder) { ?>placeholder="<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_USER_FIELD_U_NAME') ?>"<?php } ?> />
        </div>
        <?php if (!$this->addonParams->placeholder) { ?>
            <label for="passwd"
                   class="uk-display-inline-block"> <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_USER_FIELD_PASSWORD') ?></label>
        <?php } ?>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-key"></i></span>
            <input id="passwd" type="password" name="passwd"
                   <?php if ($this->addonParams->placeholder) { ?>placeholder="<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_USER_FIELD_PASSWORD') ?>"<?php } ?> />
        </div>

        <button type="submit" class="btn btn-success"><i class="icon-ok"></i></button>

        <?php echo JHtml::_('form.token'); ?>
        <input type="hidden" name="return" value="<?php echo base64_encode($_SERVER['REQUEST_URI']) ?>"/>
        <input type="hidden" name="onestepcheckout" value="1"/>
    </form>
    <?php
}
?>
<form data2 id="oneStepCheckoutForm" name="oneStepCheckoutForm" class="js-form" action="<?php echo $this->action ?>"
      method="post" onsubmit="return oneStepCheckout.validateForm(this)">

    <div id="step5">
        <?php echo $this->step5 ?>
    </div>
    <div class="js-block-adress js-block-step2">
        <?php if ($step2number || $step2name) { ?>
            <h3 class="uk-panel-title step-header">
                <?php echo $step2number ?>
                <?php echo $step2name ?>
            </h3>
        <?php } ?>
        <div id="step2">
            <?php echo $this->step2 ?>
        </div>
    </div>
    <div class="js-block-steps-wrapper">
        <div class="js-block-step3 <?php echo ($this->step3show != 1) ? 'js-hidden' : '' ?>">
            <?php if ($step3number || $step3name) { ?>
                <h3 class="step-header">
                    <?php echo $step3number ?>
                    <?php echo $step3name ?>
                </h3>
            <?php } ?>
            <div id="step3">
                <div class="title__busket">Способы доставки</div>
                <?php echo $this->step3 ?>
            </div>
        </div>
        <div class="js-block-step4 <?php echo ($this->step4show != 1) ? 'js-hidden' : '' ?>">
            <?php if ($step4number || $step4name) { ?>
                <h3 class="step-header">
                    <?php echo $step4number ?>
                    <?php echo $step4name ?>
                </h3>
            <?php } ?>
            <div class="title__busket">Способы оплаты</div>
            <div id="step4">

                <?php echo $this->step4 ?>
            </div>
        </div>
    </div>
    <div class="js-block-step5 js-block-cart-table">
        <?php if ($step5number || $step5name) { ?>
            <h3 class="step-header">
                <?php echo $step5number ?>
                <?php echo $step5name ?>
            </h3>
        <?php } ?>

        <?php if ($this->config->display_agb) { ?>
            <div class="row_agb">

                <label class="text-info checkbox">
                    <input type="checkbox" name="agb" class="checkbox" id="agb" checked="checked"/>
                    <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_AGB_CONFIRM') ?>
                    <a class="policy" href="#"
                       onclick="window.open('<?php echo SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=agb&tmpl=component', 1); ?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;">
                        <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_AGB_POLICY') ?>
                    </a>
                    <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_AGB_AND') ?>
                    <a class="policy" href="#"
                       onclick="window.open('<?php echo SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=return_policy&tmpl=component&cart=1', 1); ?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;">
                        <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_RETURN_POLICY') ?>
                    </a>
                </label>
            </div>
        <?php } ?>
        <?php if ($this->no_return) { ?>
            <div class="row_no_return">
                <input type="checkbox" name="no_return" id="no_return"/>
                <?php echo _JSHOP_NO_RETURN_DESCRIPTION ?>
            </div>
        <?php } ?>
        <?php echo $this->_tmp_ext_html_previewfinish_agb ?>
        <!-- <div class="add_info">
			<?php if (!$this->addonParams->placeholder) { ?>
			<div class="os-name">
				<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_ADD_INFO') ?> 
			</div>
			<?php } ?>
			<textarea class="span12 js-addinfo-textarea" <?php if ($this->addonParams->placeholder) { ?>placeholder="<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_ADD_INFO') ?>"<?php } ?> width="100%" id="order_add_info" name="order_add_info"></textarea>
		</div>  -->
        <?php echo $this->_tmp_ext_html_previewfinish_end ?>
    </div>

    <div class="text-center">
		<div class="basket__btn-rassrochka" style="position:relative">
			<p class="btn open rassrochka">Оформить рассрочку</p>
		</div>

        <button type="submit" id="button_order_finish" class="btn btn-info button_order_finish">
            <i class="icon-ok"></i>
            <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_ORDER_FINISH') ?>
        </button>
	</div>
		<?php echo JHtml::_('form.token'); ?>
    <p></p>
		<a href="/media/редакция_Рассрочка МТС.pdf" target="_blank">Узнать подробнее об условиях предоставления рассрочки</a>
	
</form>

<div class="popup_rassrochka">
    <div class="popup_rassrochka--container">
        <p class="popup_rassrochka--close">X</p>
        <h3 class="popup_rassrochka--title" dadada>Оформить рассрочку</h3>
        <div class="popup_rassrochka--buttons">
            <button class="MTS rassrochka">Рассрочка от МТС Банка</button>  
        
			<?//<a class="rassrochka pos-credit-container" id="pos-credit-link">Рассрочка от Почта Банка</a>?>
        </div>
    </div>
</div>



<?php if (!$this->config->without_payment) { ?>
    <form id="payment_form" name="payment_form" action="javascript:void(0)" method="post">
        <input type="hidden" name="check_payment_form" value="1"/>
        <?php echo JHtml::_('form.token'); ?>
    </form>
    <?php
}
?>
<!--Виджет v2-->




<!-- <script>
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
            fullName: 'ttt ttt2 ttt3',
            phone: '88009999999',
            brokerAgentId: 'NON_BROKER',
            returnUrl: '', //ссылка на страницу на которую возвращаемся после заполнения анкеты.
            order: [{
                category: '262',
                mark: 'Лодка', // название товара или услуги
                model: 'Лодка',  // название товара или услуги
                quantity: 1, // количество
                price: 33000.99, // Сумма заявки
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
</script> -->

<!--Виджет v2 конец-->


</div>
</div>
</div>
</div>
<br/>
<br/>

