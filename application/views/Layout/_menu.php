<nav class="top-nav">
  	<ul>
  		<!-- Dashboard -->
  		<li>
  			<a href="<?=base_url('home')?>"
  				class="top-menu <?=($this->uri->uri_string()=='home')? 'top-menu--active' : ''?> ">
  				<div class="top-menu__icon"> <i data-lucide="home"></i> </div>
  				<div class="top-menu__title"> Dashboard </div>
  			</a>
  		</li>

  		<!-- Data Master -->
		<?php if($this->session->userdata('role')=='admin'){ ?>
  		<li>
  			<a href="javascript:;" class="top-menu <?= (strpos($this->uri->uri_string(), 'admin/siswa') === 0 || strpos($this->uri->uri_string(), 'admin/guru') === 0 || strpos($this->uri->uri_string(), 'admin/kelas') === 0 || strpos($this->uri->uri_string(), 'admin/mapel') === 0 || strpos($this->uri->uri_string(), 'admin/tahun_ajaran') === 0) ? 'top-menu--active' : '' ?>">
  				<div class="top-menu__icon"> <i data-lucide="monitor"></i> </div>
  				<div class="top-menu__title">Data Master 
  					<i data-lucide="chevron-down" class="top-menu__sub-icon"></i>
  				</div>
  			</a>
  			<ul class="">
  				<li>
  					<a href="<?=base_url('admin/siswa')?>"
  						class="top-menu <?= (strpos($this->uri->uri_string(), 'admin/siswa') === 0) ? 'top-menu--active' : '' ?>"> <!-- Gunakan top-menu--active untuk submenu -->
  						<div class="top-menu__icon"> <i data-lucide="users"></i> </div>
  						<div class="top-menu__title"> Data Siswa </div>
  					</a>
  				</li>
  				<li>
  					<a href="<?=base_url('admin/guru')?>"
  						class="top-menu <?= (strpos($this->uri->uri_string(), 'admin/guru') === 0) ? 'top-menu--active' : '' ?>"> <!-- Gunakan top-menu--active untuk submenu -->
  						<div class="top-menu__icon"> <i data-lucide="contact"></i> </div>
  						<div class="top-menu__title"> Data Guru </div>
  					</a>
  				</li>
  				<li>
  					<a href="<?=base_url('admin/kelas')?>"
  						class="top-menu <?= (strpos($this->uri->uri_string(), 'admin/kelas') === 0) ? 'top-menu--active' : '' ?>"> <!-- Gunakan top-menu--active untuk submenu -->
  						<div class="top-menu__icon"> <i data-lucide="layout-list"></i> </div>
  						<div class="top-menu__title"> Data Kelas </div>
  					</a>
  				</li>
  				<li>
  					<a href="<?=base_url('admin/mapel')?>"
  						class="top-menu <?= (strpos($this->uri->uri_string(), 'admin/mapel') === 0) ? 'top-menu--active' : '' ?>"> <!-- Gunakan top-menu--active untuk submenu -->
  						<div class="top-menu__icon"> <i data-lucide="book"></i> </div>
  						<div class="top-menu__title"> Data Mata Pelajaran </div>
  					</a>
  				</li>
  				<li>
  					<a href="<?=base_url('admin/tahun_ajaran')?>"
  						class="top-menu <?= (strpos($this->uri->uri_string(), 'admin/tahun_ajaran') === 0) ? 'top-menu--active' : '' ?>"> <!-- Gunakan top-menu--active untuk submenu -->
  						<div class="top-menu__icon"> <i data-lucide="calendar"></i> </div>
  						<div class="top-menu__title"> Tahun Ajaran & Semester </div>
  					</a>
  				</li>
  			</ul>
  		</li>

  		<!-- Enroll -->
  		<li>
  			<a href="javascript:;" class="top-menu <?= (strpos($this->uri->uri_string(), 'admin/enrollsiswa') === 0 || strpos($this->uri->uri_string(), 'admin/enrollmapel') === 0) ? 'top-menu--active' : '' ?>">
  				<div class="top-menu__icon"> <i data-lucide="columns"></i> </div>
  				<div class="top-menu__title">Enroll 
  					<i data-lucide="chevron-down" class="top-menu__sub-icon"></i>
  				</div>
  			</a>
			<ul class="">
			<li>
				<a href="<?=base_url('admin/enrollsiswa')?>"
				class="top-menu <?= (strpos($this->uri->uri_string(), 'admin/enrollsiswa') === 0) ? 'top-menu--active' : '' ?>"> <!-- Gunakan top-menu--active untuk submenu -->
				<div class="top-menu__icon"> <i data-lucide="user-plus"></i> </div>
				<div class="top-menu__title"> Penempatan Siswa </div>
				</a>
			</li>
			<li>
				<a href="<?=base_url('admin/enrollmapel')?>"
					class="top-menu <?= (strpos($this->uri->uri_string(), 'admin/enrollmapel') === 0) ? 'top-menu--active' : '' ?>"> <!-- Gunakan top-menu--active untuk submenu -->
					<div class="top-menu__icon"> <i data-lucide="layers"></i> </div>
					<div class="top-menu__title"> Penetapan Mapel </div>
				</a>
			</li>
			</ul>
  		</li>
		<?php } ?>


  		<!-- Kelola Nilai -->
  		<li>
			<?php if($this->session->userdata('role')=='admin'){ ?>
  			<a href="<?=base_url('nilai')?>"
  				class="top-menu <?= (strpos($this->uri->uri_string(), 'nilai') === 0) ? 'top-menu--active' : '' ?>"> <!-- Gunakan top-menu--active -->
  				<div class="top-menu__icon"> <i data-lucide="file-text"></i> </div>
  				<div class="top-menu__title"> Kelola Nilai </div>
  			</a>
			<?php } ?>
  		</li>

  		<!-- Laporan -->
  		<li>
  			<a href="<?=base_url('laporan')?>"
  				class="top-menu <?= (strpos($this->uri->uri_string(), 'laporan') === 0) ? 'top-menu--active' : '' ?>"> <!-- Ditambahkan penanda aktif -->
  				<div class="top-menu__icon"> <i data-lucide="book-open"></i> </div>
  				<div class="top-menu__title"> Laporan</div>
  			</a>
  		</li>

  		<!-- User -->
		<?php if($this->session->userdata('role')=='admin'){ ?>
  		<li>
  			<a href="<?=base_url('user')?>"
  				class="top-menu <?= (strpos($this->uri->uri_string(), 'user') === 0) ? 'top-menu--active' : '' ?>"> <!-- Gunakan top-menu--active -->
  				<div class="top-menu__icon"> <i data-lucide="user"></i> </div>
  				<div class="top-menu__title"> User </div>
  			</a>
  		</li>
		<?php } ?>

  	</ul>
</nav>