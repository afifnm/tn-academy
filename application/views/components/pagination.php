<div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
	<nav class="w-full sm:w-auto sm:mr-auto">
		<?= $pagination ?>
	</nav>
	<select class="w-20 form-select box mt-3 sm:mt-0" onchange="location.href='?limit='+this.value">
		<option <?= $this->input->get('limit') == 10 ? 'selected' : '' ?>>10</option>
		<option <?= $this->input->get('limit') == 25 ? 'selected' : '' ?>>25</option>
		<option <?= $this->input->get('limit') == 35 ? 'selected' : '' ?>>35</option>
		<option <?= $this->input->get('limit') == 50 ? 'selected' : '' ?>>50</option>
	</select>
</div>
