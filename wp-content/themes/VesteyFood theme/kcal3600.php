<?php /* Template Name:Kcal3600 */ ?>
<?php get_header(); ?>
<?php get_header('pages');
get_template_part('widget-menue');

?>


	

<?php
 $filters = array();
    if (isset($_GET['key'])&& $_GET['key']!=null)
    {
        $filters= $_GET['key'];
    }
$categoriesids= array();
if($filters)
{

foreach($filters as $filter)
{
    switch($filter)
    {
        case 'Lactose Free': array_push($categoriesids,50); break;
        case 'Generic':      array_push($categoriesids,51); break;
        case 'Gluten Free':  array_push($categoriesids,52); break;
        case 'Vegetarian':   array_push($categoriesids,53); break;
        case 'Halal':        array_push($categoriesids,54); break;
    }

    
}
}
else {
    $categoriesids = array(50,51,52,53,54);
}

                $mealargs = array(
                    'post_type' => '3600kcal_meal',
                    'post_status' => 'publish',
                    'orderby'        => 'CAST(title as unsigned)',
                    'order' => 'ASC',
                    'category__in' => $categoriesids,
                    'posts_per_page' => -1,
                                );
$meals= new WP_Query( $mealargs );

if ($meals->have_posts()):  while ($meals->have_posts()) : $meals->the_post();
$meal_id = get_the_ID();

//stake
$morder=1;

//


$productsids = array();
 $productsids= (get_field('mealproducts',get_the_ID())!=null)? get_field('mealproducts',get_the_ID()):array(-1);
//$products = get_field('products', get_the_ID());
//if($products){ $i=0;  foreach($products as $p){ $productsids[$i] = $p->ID ; $i++; } }

$post_categories = wp_get_post_categories( get_the_ID() );
$cats = array();
$ind=0;
foreach($post_categories as $c){  $cat = get_category( $c ); $cats[$ind++] =$cat->name ; }
?>
<div class="container">
		<div class="menu-list">
			<div class="list">
                
                
    
				<div class="row">

					<div class="col-12 title">
                    
                     
<h6><?php the_title(); echo " "; $echo_slash= false; foreach($cats as $cat){ if($echo_slash){echo '/';} echo $cat; $echo_slash= true; }?></h6>
                    
						<div class="space"></div>
					</div>

<!--looooooop the products here-->
                    <?php 

                $meal_products_args = array(
                    'post_type' => 'product',
                     'post__in' => $productsids,
                    'post_status' => 'publish',
                    'orderby'=>'post__in',
                                );
                        $meals_products= new WP_Query( $meal_products_args );

                    if ($meals_products->have_posts()):  while ($meals_products->have_posts()) : $meals_products->the_post();
                    ?>

				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
						<a href="<?php the_permalink()?>" class="item pannel">
							<div class="product">
<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid" alt="product">
							</div>
							<div class="caption">
                                
								<h3><?php the_title();?></h3>
								<h6><?php echo get_field('size',get_the_ID());?> g</h6>
							</div>
                            
                            <?php
                            $meal_type= array();
                            $product_type = get_field('choose_meal_type',get_the_ID());
                            if( $product_type == 'Meal')
                            {
                            $meal_type= get_field('meal_type',$meal_id);
                            }
                            
                            ?>
							<span class="product-title">
                                <?php
                                if( $product_type != 'Meal'){echo $product_type;}
                                else{
                                    switch($morder){
                                        case 1: echo 'Breakfast'; $morder=2; break; 
                                        case 2: echo 'Lunch'; $morder=3; break;
                                        case 3: echo 'Dinner'; $morder=1; break;
                                            
                                    }
                                    
                                    
                                    /*
                                    $echo_slash= false;
                                    foreach($meal_type as $pt)
                                    {
                                        if($echo_slash)
                                        {
                                            echo '/';
                                        } 
                                        echo $pt;
                                        $echo_slash= true;
                                    }*/
                                }
                                
                                
                                ?></span>
						</a>
					</div>

					
                    <?php endwhile;endif;?>
                    <div class="space"></div>
				</div>
                
    
			</div>

		</div>
	</div>

	<div class="divider"></div>
<div class="space"></div>

	<?php endwhile;endif;?>


		<!--<div class="spinner"></div>-->

  <?php get_footer(); ?>
	<!--  End  The menu lis -->
	<!-- End The Area of Work -->