<?php defined('_JEXEC') or die(); ?>
<?php $in_row = $this->config->product_count_related_in_row; ?>
<?php $product = $this->product?>

<div class="jshop_list_product">
    <div class="row-fluid jshop list_related">
        <?php foreach ($this->categories_additional_equipment as $categories) { ?>
            <div class="block_product">
                <? $category = (array) $categories[0]?>
<!--                --><?php //echo "<pre>", print_r($categories), "</pre>"; ?>
<!--                --><?php //echo "<pre>", print_r($category['category_url']), "</pre>"; ?>
                <div class="category-name">
                    <a href="tuning/<?= $category['category_url'] ?>"><?php echo $category['category_name'] ?></a>
                </div>
                <div class="test">
                <?php foreach ($categories as $product) {
                    $arProduct = (array) $product;?>
                    <div class="block_product span4">
                                <div class="product productitem_442">

                                    <div data-image="" class=" image">
                                        <div class="image_block">
                                            <a href="tuning/<?= $category['category_url'] ?>/<?= $arProduct['products_url'] ?>">
                                                <img class="jshop_img"
                                                     src="http://test.big-boat.ru/components/com_jshopping/files/img_products/<?php echo $arProduct['image'] ?>"
                                                     alt="<?= $arProduct['name_ru-RU'] ?>">
                                            </a>
                                        </div>
                                    </div>

                                    <div class=" mainblock">
                                        <!-- звезды -->
                                        <div class="review_mark">
                                            <div class="stars_no_active" style="width:80px">
                                                <div class="stars_active" style="width:0px">
                                                    <?php echo showMarkStar($arProduct['average_rating']);?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- название товара -->
                                        <p align="left" style="margin-left: 15px; color:#2a3950; text-decoration: underline;">
                                    <span style="font-size: x-large;" class="product_title ">
                                        <a href="tuning/<?= $category['category_url'] ?>/<?= $arProduct['products_url'] ?>"><?= $arProduct['name_ru-RU'] ?></a>
                                    </span>
                                        </p>

                                        <!-- цена -->
                                        <div class="jshop_price_block">
                                            <div class="jshop_price"><span><?= $arProduct['min_price'] ?> руб.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a class="btn btn-success button_buy" href="/">В корзину </a>
                                        <a class="btn btn-info button_detail" href="tuning/<?= $category['category_url'] ?>/<?= $arProduct['products_url'] ?>">
                                            Узнать подробнее
                                        </a>
                                    </div>
                                </div>
                            </div>
                <?php } ?>
                </div>

                <div class="category-name link">
                    <a href="tuning/<?= $category['category_url'] ?>">Посмотреть все</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>