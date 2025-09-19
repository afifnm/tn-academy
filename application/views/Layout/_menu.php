<nav class="top-nav">
  	<ul>
  		<li>
  			<a href="<?=base_url('home')?>"
  				class="top-menu <?=($this->uri->uri_string()=='home')? 'top-menu--active' : ''?> ">
  				<div class="top-menu__icon"> <i data-lucide="home"></i> </div>
  				<div class="top-menu__title"> Dashboard </div>
  			</a>
  		</li>
  		<li>
  			<a href="javascript:;" class="top-menu">
  				<div class="top-menu__icon"> <i data-lucide="monitor"></i> </div>
  				<div class="top-menu__title">Data Master <i data-lucide="chevron-down" class="top-menu__sub-icon"></i>
  				</div>
  			</a>
  			<ul class="">
  				<li>
  					<a href="side-menu-light-dashboard-overview-1.html" class="top-menu">
  						<div class="top-menu__icon"> <i data-lucide="users"></i> </div>
  						<div class="top-menu__title"> Data Siswa </div>
  					</a>
  				</li>
  				<li>
  					<a href="side-menu-light-dashboard-overview-1.html" class="top-menu">
  						<div class="top-menu__icon"> <i data-lucide="contact"></i> </div>
  						<div class="top-menu__title"> Data Guru </div>
  					</a>
  				</li>
  				<li>
  					<a href="side-menu-light-dashboard-overview-1.html" class="top-menu">
  						<div class="top-menu__icon"> <i data-lucide="layout-list"></i> </div>
  						<div class="top-menu__title"> Data Kelas </div>
  					</a>
  				</li>
  				<li>
  					<a href="side-menu-light-dashboard-overview-1.html" class="top-menu">
  						<div class="top-menu__icon"> <i data-lucide="book"></i> </div>
  						<div class="top-menu__title"> Data Mata Pelajaran </div>
  					</a>
  				</li>
  				<li>
  					<a href="side-menu-light-dashboard-overview-1.html" class="top-menu">
  						<div class="top-menu__icon"> <i data-lucide="calendar"></i> </div>
  						<div class="top-menu__title"> Data Tahun Ajaran & <br> Semester </div>
  					</a>
  				</li>
  				<li>
  					<a href="side-menu-light-dashboard-overview-1.html" class="top-menu">
  						<div class="top-menu__icon"> <i data-lucide="columns"></i> </div>
  						<div class="top-menu__title"> Data Rombel </div>
  					</a>
  				</li>
  			</ul>
  		</li>
  		<li>
  			<a href="javascript:;" class="top-menu">
  				<div class="top-menu__icon"> <i data-lucide="file-text"></i> </div>
  				<div class="top-menu__title"> Kelola Nilai </div>
  			</a>
  		</li>
  		<li>
  			<a href="javascript:;" class="top-menu">
  				<div class="top-menu__icon"> <i data-lucide="book-open"></i> </div>
  				<div class="top-menu__title"> Laporan</div>
  			</a>
  		</li>
  		<li>
  			<a href="<?=base_url('user')?>"
  				class="top-menu  <?= (strpos($this->uri->uri_string(), 'user') === 0) ? 'top-menu--active' : '' ?>">
  				<div class="top-menu__icon"> <i data-lucide="user"></i> </div>
  				<div class="top-menu__title"> User </div>
  			</a>
  		</li>
  	</ul>
  </nav>
