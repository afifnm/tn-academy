  <div
  	class="top-bar-boxed h-[70px] z-[51] relative border-b border-white/[0.08] mt-12 md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 md:pt-0 mb-12">
  	<div class="h-full flex items-center">
  		<!-- BEGIN: Logo -->
  		<a href="" class="-intro-x hidden md:flex">
  			<img alt="Midone - HTML Admin Template" class="w-6" src="<?= base_url('assets/') ?>dist/images/logo.svg">
  			<span class="text-white text-lg ml-3"> TN ACADEMY </span>
  		</a>
  		<!-- END: Logo -->
  		<!-- BEGIN: Breadcrumb -->
  		<nav aria-label="breadcrumb" class="-intro-x h-full mr-auto">
  			<ol class="breadcrumb breadcrumb-light">
  				<li class="breadcrumb-item"><a href="#">Application</a></li>
  				<li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
  			</ol>
  		</nav>
  		<!-- END: Breadcrumb -->
  		<!-- BEGIN: Account Menu -->
  		<div class="intro-x dropdown w-8 h-8">
  			<div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110"
  				role="button" aria-expanded="false" data-tw-toggle="dropdown">
  				<img alt="Midone - HTML Admin Template" src="<?= base_url('assets/') ?>dist/images/profile-5.jpg ">
  			</div>
  			<div class="dropdown-menu w-56">
  				<ul
  					class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
  					<li class="p-2">
  						<div class="font-medium"><?= $this->session->userdata('nama');?></div>
  						<div class="text-xs text-white/60 mt-0.5 dark:text-slate-500"><?= $this->session->userdata('role');?></div>
  					</li>
  					<li>
  						<hr class="dropdown-divider border-white/[0.08]">
  					</li>
  					<li>
  						<a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="help-circle"
  								class="w-4 h-4 mr-2"></i> Panduan </a>
  					</li>
  				
  					<li>
  						<a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="lock"
  								class="w-4 h-4 mr-2"></i> Reset Password </a>
  					</li
  					<li>
  						<hr class="dropdown-divider border-white/[0.08]">
  					</li>
  					<li>
  						<a href="<?=base_url('auth/logout')?>" class="dropdown-item hover:bg-white/5"> <i data-lucide="toggle-right"
  								class="w-4 h-4 mr-2"></i> Logout </a>
  					</li>
  				</ul>
  			</div>
  		</div>
  		<!-- END: Account Menu -->
  	</div>
  </div>
