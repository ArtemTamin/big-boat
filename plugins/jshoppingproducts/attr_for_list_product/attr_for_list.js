function notUseAttrValue(a, b) {}

function thousands(amount, separator) {
    return amount.split('').reverse().join('').replace(/\d{3}/g, '$&' + separator).split('').reverse().join('');
}

function serializeAttrib(id, jqThisClosest) {
    "use strict";
    var b = jqThisClosest.find(jQuery(".attrforprodid_" + id + " select, .attrforprodid_" + id + " input:radio")).serializeArray();
    jQuery(".attr_link").empty();
    jQuery(".buy_link").empty();
    jQuery.each(b, function(a, b) {
        var d = b.name.split("jshop_attr_id")[1],
            f = b.name.split("-")[1],
            f = null === f || void 0 === f ? b.name : f;
        jQuery(".attr_link").append("&attr" + d + "=" + b.value);
        jQuery(".buy_link").append("&" + f + "=" + b.value);
    });
}

function addAttribToButtonBy(wrap_selector, attr_selector) {
    "use strict";
    jQuery("body").on("click", ".button_buy", function() {
        var jqThis = jQuery(this),
            jqThisClosest = jqThis.closest(wrap_selector),
            id = jqThisClosest.find(attr_selector).data("attrforprodid");
        jQuery(".buy_link").remove();
        jqThisClosest.find(jQuery(".attrforprodid_" + id)).append("<div class='buy_link' style='display:none'></div>");
        serializeAttrib(id, jqThisClosest);
        jqThis.attr("href", function(a, c) {
            return c + jQuery(".buy_link").text();
        });
    });
}

function showEmptyAlert(id, text, jqThisClosest, attr_selector) {
    "use strict";
    jqThisClosest.find(attr_selector).append('<div class="attrib-empty-option"><div>' + text + ' <span>&times;</span></div></div>');
    var attr_position = jqThisClosest.find(attr_selector).position(),
        eo_height = jqThisClosest.find(".attrib-empty-option").height();
    jqThisClosest.find(".attrib-empty-option")
        .css({ "display": "block", "top": attr_position.top - eo_height })
        .animate({ opacity: 1 }, 500, function() {
            if (jQuery(attr_selector).data("autohide") == 2) {
                setTimeout(function() {
                    jqThisClosest.find(".attrib-empty-option").fadeOut("slow", function() {
                        jQuery(this).remove();
                    });
                }, 5000);
            }
        });
    jqThisClosest.click(function() {
        jqThisClosest.find(".attrib-empty-option").fadeOut("slow", function() { jQuery(this).remove(); });
    });
}

function hideButtonBuy(id, jqThisClosest, attr_selector) {
    "use strict";
    if (jQuery(attr_selector).data("buttonbuy") == 2) {
        jqThisClosest.find(".button_buy:visible").hide("slow");
    } else if (jQuery(attr_selector).data("buttonbuy") == 3) {
        jqThisClosest.find(".button_buy:visible").addClass("disable_buttonbuy");
        jQuery("body").on("click", ".disable_buttonbuy", function(e) {
            e.preventDefault();
        });
    }
}

function showButtonBuy(id, jqThisClosest, attr_selector) {
    "use strict";
    if (jQuery(attr_selector).data("buttonbuy") == 2) {
        jqThisClosest.find(".button_buy:hidden").show("slow");
    } else if (jQuery(attr_selector).data("buttonbuy") == 3) {
        jqThisClosest.find(".button_buy:visible").removeClass("disable_buttonbuy");
    }
}

function mainAttrChange(jqThis, wrap_selector, attr_selector, url, text, img_folder, img_blank, empty_text) {
    "use strict";
    var attr_id = jqThis.parent("span").data("id"),
        id_num = "id_" + attr_id,
        jqThisClosest = jqThis.closest(wrap_selector),
        id = jqThisClosest.find(attr_selector).data("attrforprodid"),
        qty = jqThisClosest.find("input[name^='quantity']") ? jqThisClosest.find("input[name^='quantity']").val() : "1";
    jQuery(".attr_link").remove();
    jQuery(".buy_link").remove();
    jqThisClosest.find(jQuery(".attrforprodid_" + id)).append("<div class='attr_link' style='display:none'></div><div class='buy_link' style='display:none'></div>");
    serializeAttrib(id, jqThisClosest);
    jQuery.ajax({
        cache: !1,
        url: url + "index.php?option=com_jshopping&controller=product&task=ajax_attrib_select_and_price&product_id=" +
            id + jQuery(".attr_link").text() + "&qty=" + qty + "&ajax=1&fid=afl",
        beforeSend: function() {},
        dataType: "json",
        ifModified: !0,
        success: function(b) {
            for (var key in b) {
                if (key === id_num && b.hasOwnProperty(key)) {
                    var img = jQuery(b[key]).find("img");
                    jqThis.next("span").html(img);
                }
            }
            if (b.displaybuttons == 0) {
                showEmptyAlert(id, text, jqThisClosest, attr_selector);
                hideButtonBuy(id, jqThisClosest, attr_selector);
            } else {
                showButtonBuy(id, jqThisClosest, attr_selector);
            }
            if (jqThisClosest.find(".jshop_price span, .modopprod_item_price span").text() != b.price) {
                jqThisClosest.find(".jshop_price, .modopprod_item_price").css("position", "relative").append('<div class="ajaxloaddingcart_mini"></div>');
                setTimeout(function() { jQuery(".ajaxloaddingcart_mini").remove(); }, 500);
            }
            jqThisClosest.find(".qty_in_stock span").text(b.qty);
            if (b.images) {
                jqThisClosest.find(".image_block a img, .modopprod_item_image a img").attr("src", img_folder + "thumb_" + b.images[0]).addClass("jshop_img");
            }
            if (b.block_image_middle) {
                var c = jqThisClosest.find(".image_block a img").parent("a").html(b.block_image_middle);
                jqThisClosest.find(".image_block a").parent("a").html(c.find("img[id^='main_image_']").first());
                c = jqThisClosest.find(".image_block a img").attr("src");
                if (c) {
                    c = c.substring(c.lastIndexOf("/"), c.length).split("/")[1];
                }
                jqThisClosest.find(".image_block a img").attr("src", img_folder + "thumb_" + c).addClass("jshop_img");
            }
            if (jQuery(attr_selector).data("calc") === 2) {
                setTimeout(function() {
                    var price_q = parseFloat(b.pricefloat) * qty;
                    var price_currency = jQuery(attr_selector).data("currency");
                    var decimal_count = jQuery(attr_selector).data("decimal");
                    var thousand_separator = jQuery(attr_selector).data("ths");
                    jqThisClosest.find(".jshop_price span, .modopprod_item_price span").html(thousands(price_q.toFixed(decimal_count), thousand_separator) + " " + price_currency).fadeTo("fast", 1);
                }, 700);
            } else {
                setTimeout(function() {
                    jqThisClosest.find(".jshop_price span, .modopprod_item_price span").html(b.price).fadeTo("fast", 1);
                }, 700);
            }
            jqThisClosest.find(".jshop_code_prod span").html(b.ean);
            jqThisClosest.find(".jshop_manufacturer_prod span").html(b.manufacturer_code);
            jqThisClosest.find(".productweight span").html(b.weight);
            if (jqThisClosest.find(".old_price span").length && b.oldprice !== undefined) {
                jqThisClosest.find(".old_price span").html(b.oldprice);
            } else if (!jqThisClosest.find(".old_price span").length && jqThisClosest.find(".old_price_wrap").length && b.oldprice !== undefined) {
                jqThisClosest.find(".old_price_wrap").html('<span class="old_price"><span>' + b.oldprice + '</span></span>');
            }
            //jqThisClosest.find("span.attr_arr").each(function() {
            jQuery.each(jqThisClosest.find(jQuery(".attr_arr")), function() {
                //jQuery.each(b, function() {
                var jqThis = jQuery(this),
                    attrib = jQuery(this).data("id"),
                    attrPrefix = jQuery(this).data("attrprefix");

                jqThisClosest.find(jQuery(".attr_arr[data-id='" + attrib + "']")).html(b['id_' + attrib]);

                //INPUT
                //jqThisClosest.find("input:radio").removeAttr("onclick").attr("id", function() {});
                jqThis.find(jQuery(".attr_arr[data-id='" + attrib + "'] input:radio")).removeAttr("onclick").attr({
                    "id": function() {
                        return attrPrefix + "_jshop_attr_id" + attrib + jQuery(this).val();
                    },
                    "name": function() {
                        return attrPrefix + "-jshop_attr_id[" + attrib + "]";
                    }
                });
                jqThis.find(jQuery(".attr_arr[data-id='" + attrib + "'] label")).attr("for", function() {
                    return attrPrefix + "_jshop_attr_id" + attrib + jQuery(this).prev("input").val();
                });
                //jqThisClosest.find(".input_type_radio label").attr("for", function() {});

                //SELECT
                //jqThisClosest.find("select").removeAttr("onchange").removeAttr("id");
                jqThis.find("select").removeAttr("onchange").removeAttr("id").attr("name", function(i, val) {
                    return attrPrefix + "-" + val;
                });
                //});
            });
            serializeAttrib(id, jqThisClosest);

            jqThisClosest.find(".prod_attr_img img").not(".attrforprodid_" + id + " .prod_attr_img img").each(function() {
                jQuery(this).attr("src", img_blank);
            });
            if (jQuery(".attr_noempty").length || jQuery(".noempty_0").length) {
                jqThisClosest.find("select").not(jqThisClosest.find("select")).each(function() {
                    jqThisClosest.find("select [value='0']").length || jQuery(this).prepend(empty_text);
                });
                jqThisClosest.find(".prod_attr_img img").not(".attrforprodid_" + id + " .prod_attr_img img").each(function() {
                    jQuery(this).attr("src", img_blank);
                });
            }
        },
        error: function() {
            jQuery(".ajaxloaddingcart_mini").remove();
        }
    }).
    done(function() {});
    if (!jQuery("#jshop_module_cart_mini").length || !jQuery("*[id^='jshop_module_cart_mini']").length) {
        jQuery("body").on("click", jqThisClosest.find(jQuery(".button_buy")), function() {
            jQuery(this).attr("href", function(a, c) {
                return c + jQuery(".buy_link").text();
            });
        });
    }
}

function runAttribAjax() {
    var attr_selector = ".attrib",
        wrap_selector = jQuery(attr_selector).data("wrapclass"),
        url = jQuery(attr_selector).data("uri-base"),
        quantity_selector = ".count.p_p, .count.p_m, .list_product input.product_plus, .list_product input.product_minus",
        quantity_input = ".list_product input[name^='quantity'], .modopprod_item input[name^='quantity']",
        text = jQuery(attr_selector).data("text"),
        textsel = jQuery(attr_selector).data("textsel"),
        empty_text = '<option value="0" selected="selected">' + textsel + '</option>',
        img_folder = url + "components/com_jshopping/files/img_products/",
        img_blank = url + "components/com_jshopping/images/blank.gif";
    jQuery(".jshop.list_product:hidden").find(attr_selector).remove();
    //*****start*****//
    if (!jQuery(attr_selector).data("fe") && !jQuery(".noempty_1").length) {
        jQuery(attr_selector + " input:radio").each(function() {
            jQuery(this).removeAttr("checked", "checked");
        });
        jQuery(attr_selector + " select").each(function() {
            jQuery(this).find("option:selected").removeAttr("selected", "selected");
            jQuery(this).prepend(empty_text);
        });
        jQuery(attr_selector + " .prod_attr_img img").each(function() {
            jQuery(this).attr("src", img_blank);
        });
    }

    if (jQuery(attr_selector).data("fe") && jQuery(".noempty_1").length) {
        jQuery(attr_selector + " select").each(function() {
            jQuery(this).find("option:selected").remove();
        });
        jQuery(".att_none span.attr_arr").each(function() {
            jQuery(this).find("select option:nth-child(1)").attr("selected", "selected");
            jQuery(this).find("input:radio").eq(0).attr("checked", "checked");
        });
    }

    jQuery("body").on("click", quantity_selector, function() {
        var jqThis = jQuery(this);
        jqThis.parents("div.block_product").find(".jshop_price span").fadeTo("fast", 0.01);
        setTimeout(function() {
            jqThis.parents("div.count_block, div.block_product").find("input[name^='quantity']").change();
        }, 500);
    });
    jQuery("body").on("keyup", quantity_input, function() {
        var jqThis = jQuery(this);
        jqThis.parents("div.block_product").find(".jshop_price span").fadeTo("fast", 0.01).trigger("click");
        setTimeout(function() {
            jqThis.parents("div.count_block, div.block_product").find("input[name^='quantity']").change();

        }, 500);
        jqThis.parents("div.block_product, .modopprod_item").find(".button_buy").hover(function() {
            jQuery(this).focus();
        });
    });


    jQuery("body").on("change", quantity_input, function() {
        var jqThis = jQuery(this);
        mainAttrChange(jqThis, wrap_selector, attr_selector, url, text, img_folder, img_blank, empty_text);
    });

    jQuery(attr_selector).length && jQuery("body").on("change", attr_selector + " select, " + attr_selector + " input", //+quantity_input,
        function() {
            mainAttrChange(jQuery(this), wrap_selector, attr_selector, url, text, img_folder, img_blank, empty_text);
        });

    if (!jQuery("#jshop_module_cart_mini").length && !jQuery("*[id^='jshop_module_cart_mini']").length) {
        addAttribToButtonBy(wrap_selector, attr_selector);
    }

    if (jQuery(".jshop.list_product").is(":hidden") && jQuery(".attrib").data("fe")) {
        jQuery(".att_none span.attr_arr").each(function() {
            jQuery(this).find("select option:nth-child(1)").attr("selected", "selected");
            jQuery(this).find("input:radio").eq(0).attr("checked", "checked");
        });
    }
}

jQuery(function() {
    "use strict";
    runAttribAjax();
    jQuery(".recalc_attr .attr_arr select, .recalc_attr .attr_arr input").change();
    //*****end******//
});