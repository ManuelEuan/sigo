<body>
<div class="body">
	<header id="header" class="header-effect-shrink"
			data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
		<div class="header-body header-body-bottom-border border-top-0">
			<div class="header-container container">
				<div class="header-row">
					<div class="header-column">
						<div class="header-row">
							<div class="header-logo">
								<a href="<?=base_url()?>control_pagina/index">
									<img alt="compromisos width="82" height="40" src="<?=base_url();?>img/logo_compromiso.png">
								</a>
							</div>
						</div>
					</div>
					<div class="header-column justify-content-end">
						<div class="header-row">
							<div class="header-nav header-nav-line header-nav-bottom-line header-nav-bottom-line-effect-1"
								 style="justify-content: flex-start !important;  ">
								<div class="header-nav-main header-nav-main-square header-nav-main-effect-2 header-nav-main-sub-effect-1">
									<nav class="collapse">
										<ul class="nav nav-pills" id="mainNav">
											<li class="dropdown">
												<a class="dropdown-item dropdown-toggle <?php echo ($pag == 1) ? 'active' : ''; ?>" href="<?=base_url()?>control_pagina/index">
													Inicio
												</a>
											</li>
											<li class="dropdown dropdown-mega">
												<a class="dropdown-item dropdown-toggle <?php echo ($pag == 2) ? 'active' : ''; ?>" href="<?=base_url()?>compromisos/listar">
													Compromisos
												</a>
											</li>
										</ul>
									</nav>
								</div>
								<button class="btn header-btn-collapse-nav" data-toggle="collapse"
										data-target=".header-nav-main nav">
									<i class="fas fa-bars"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
