<!-- Banner -->
<div class="bnr" id="home">
    <div  id="top" class="callbacks_container">
        <ul class="rslides" id="slider4">
            <li>
                <img src="images/bnr-1.jpg" alt=""/>
            </li>
            <li>
                <img src="images/bnr-2.jpg" alt=""/>
            </li>
            <li>
                <img src="images/bnr-3.jpg" alt=""/>
            </li>
        </ul>
    </div>
    <div class="clearfix"> </div>
</div>
<!-- Banner -->

<!-- Brands -->
<?php if($brands): ?>
    <div class="about">
        <div class="container">
            <div class="about-top grid-1">
                <?php foreach ($brands as $brand): ?>
                    <div class="col-md-4 about-left">
                        <figure class="effect-bubba">
                            <img class="img-responsive" src="images/<?= $brand->img ?>" alt=""/>
                            <figcaption>
                                <h2><?= $brand->title ?></h2>
                                <p><?= $brand->description ?></p>
                            </figcaption>
                        </figure>
                    </div>
                <?php endforeach; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--end Brands -->

<!-- May be Popular products , Lasts products or News products -->
<?php if($hits): ?>

<!-- Get Currency from container -->
    <?php  $curr = \Framework\App::$app->get('currency'); ?>
<!-- End Currency -->

<div class="product">
    <div class="container">
        <div class="product-top">
            <div class="product-one">
                <?php foreach ($hits as $hit): ?>
                    <div class="col-md-3 product-left">
                        <div class="product-main simpleCart_shelfItem">
                            <a href="product/<?= $hit->alias ?>" class="mask">
                                <img class="img-responsive zoom-img" src="images/<?= $hit->img ?>" alt="" />
                            </a>
                            <div class="product-bottom">
                                <h3>
                                    <a href="product/<?= $hit->alias ?>">
                                        <?= $hit->title ?>
                                    </a>
                                </h3>
                                <p>Explore Now</p>
                                <h4>
                                    <a data-id="<?= $hit->id ?>" class="add-to-cart-link" href="cart/add?id=<?= $hit->id ?>"><i></i></a>
                                    <span class=" item_price">
                                        <!--
                                             must to create function for format_price($price)
                                             and use  php format_number() for surround value
                                         -->
                                        <?= $curr['symbol_left'] . ($hit->price * $curr['value']). $curr['symbol_right'] ?>
                                        <!-- end function -->
                                    </span>
                                    <!-- show old price if has -->
                                    <?php if($hit->old_price): ?>
                                      <small>
                                          <del>
                                              <?= $curr['symbol_left'] . ($hit->old_price * $curr['value']) . $curr['symbol_right'] ?>
                                          </del>
                                      </small>
                                    <?php endif; ?>
                                    <!-- end show old price -->
                                </h4>
                            </div>
                            <!-- if(old_price)  -->
                            <div class="srch">
                                <!-- do: 50 = (old_price - price) * 100 -->
                                <span>-50%</span>
                            </div>
                            <!-- endif  -->
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- end Propular products -->