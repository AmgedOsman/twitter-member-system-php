<?php
/*LoadLibrary*/
if ( ! defined( 'IN_SCRIPT' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly.";
	exit();
}

$this->pageviewPlusOne();

    
?>
		</div><!-- /.blog-main -->
		<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <h4><?php echo $this->words['about'];?></h4>
            <p><?php echo $this->settings['desc'];?></p>
          </div>
          <div class="sidebar-module">
            <h4><?php echo $this->words['nav'];?></h4>
            <ol class="list-unstyled">
              <li><a href="<?php $this->seoURL('howto');?>">How To</a></li>
              
            </ol>
          </div>
          <?php
            if(count($this->settings['social']) && is_array($this->settings['social'])) {
          ?>
          <div class="sidebar-module">
            <h4><?php echo $this->words['social'];?></h4>
            <ol class="list-unstyled">
            <?php
				foreach ($this->settings['social'] as $k => $v){
					if ($v)
					{
			?>
					<li><a href="<?php echo $v;?>"><i class="fa fa-fa fa-<?php echo $k;?>"></i> <?php echo ucwords($k);?></a></li>
			<?php
					}
				}
            ?>
            
            </ol>
          </div>
         <?php } //end social ?>
        </div><!-- /.blog-sidebar -->
	</div><!-- row -->
</div><!-- container -->

 <footer class="footer">
      <div class="container">
        <p class="text-muted">
			<div class="pull-left"><strong><?php echo $this->make_niceNumbers($this->pageviewCount()); ?></strong> views</div>
			<div class="pull-right">Made in <img src="<?php echo $this->settings['public_url'].'imgs/';?>eg.png" alt='egypt flag' title='Egypt' /> by <a href="https://twitter.com/intent/follow?ref_src=twsrc%5Etfw&region=follow_link&screen_name=Amged&tw_p=followbutton">Amged</a></div>
        </p>
		</div>
 </footer>

<script>
//https://dev.twitter.com/web/javascript/events
//http://stackoverflow.com/questions/4947825/is-there-a-callback-for-twitters-tweet-button
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<script type="text/javascript">
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','__gaTracker');

	__gaTracker('create', 'UA-60449547-1', 'auto');
	__gaTracker('set', 'forceSSL', true);
	__gaTracker('require', 'displayfeatures');
	__gaTracker('require', 'linkid', 'linkid.js');
	__gaTracker('send','pageview');

</script>
</body>
</html>