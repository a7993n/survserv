<div class="nav-collapse collapse">
					<ul class="nav">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown"><span id="selected-server" style="color:#fff;">select server</span> <b class="caret"></b></a>
							<ul id="server-dropdown" class="dropdown-menu"></ul>
						</li><!--/.dropdown -->
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-white"></i> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="dropdown-submenu">
									<a tabindex="-1" href="#">Load Style</a>
									<ul class="dropdown-menu load-style">
										<li><a data-load-style="polling"><input onClick="this.parentNode.click(); return false;" type="checkbox" /> Long Polling</a></li>
										<li><a data-load-style="event"><input onClick="this.parentNode.click(); return false;" type="checkbox" /> Event Stream</a></li>
									</ul>
								</li><!--/.dropdown-submenu -->
								<li class="dropdown-submenu">
									<a tabindex="-1" href="#">Long Poll Delay</a>
									<ul class="dropdown-menu poll-delay">
										<li><a data-poll-delay="2000"><input onClick="this.parentNode.click(); return false;" type="checkbox" /> 2 seconds</a></li>
										<li><a data-poll-delay="5000"><input onClick="this.parentNode.click(); return false;" type="checkbox" />5 seconds</a></li>
										<li><a data-poll-delay="10000"><input onClick="this.parentNode.click(); return false;" type="checkbox" />10 seconds</a></li>
										<li><a data-poll-delay="20000"><input onClick="this.parentNode.click(); return false;" type="checkbox" />20 seconds</a></li>
									</ul>
								</li><!--/.dropdown-submenu -->
							</ul><!--/.dropdown-menu -->
						</li><!--/.dropdown -->
					</ul><!--/.nav -->
				</div><!--/.nav-collapse -->
