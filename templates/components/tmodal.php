<div class="main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster"
		style="background: rgba(0,0,0,.7);display:none">
		<div
			class="border border-teal-500 shadow-lg modal-container bg-white w-11/12 md:max-w-4xl mx-auto rounded shadow-lg z-50 overflow-y-auto">
			<div class="modal-content py-4 text-left px-6" style="height:70vh">
                <form action="<?php echo $_SERVER['PHP_SELF'].'?templating'; ?>" method="post" >
				<!--Title-->
				<div class="flex justify-between items-center pb-3">
					<p class="text-2xl font-bold" id="modalTitle">Add SMS Template</p>
					<div class="modal-close cursor-pointer z-50">
						<svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
							viewBox="0 0 18 18">
							<path
								d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
							</path>
						</svg>
					</div>
				</div>
				<!--Body-->
				<div class="my-5 text-lg">
					<p class="pt-5">Name: <input id="tname" type="text" name="tname" placeholder="Template Name" class="autoexpand tracking-wide py-2 px-4 mb-3 leading-relaxed appearance-none block w-full bg-gray-200 border border-gray-200 rounded focus:outline-none focus:bg-white focus:border-gray-500" /></p>
                    
                    <!-- Message field -->
					<p class="pt-5">Content:</p>
                    <div class="flex flex-wrap my-6">
                        <div class="relative w-full appearance-none label-floating">
                            <textarea maxlength="640" rows="4" id="message" class="autoexpand tracking-wide py-2 pb-4 mb-3 leading-relaxed appearance-none block w-full bg-gray-200 border border-gray-200 rounded focus:outline-none focus:bg-white focus:border-gray-500"
								id="message" type="text" name="message" placeholder="Message..."></textarea>
								<p>
									<div class="flex justify-between items-baseline p-3">
										<div>Credit cost per sms: <span id="cost" class="text-teal-700"></span></div>
										<span class="text-teal-500" onclick="this.parentNode.nextElementSibling.classList.remove('hidden')" >Insert Variable</span>
									</div>
									<div class="relative hidden">
										<div class="absolute p-3" style="right:1rem;z-index:9999">
											<div class="overflow-auto bg-gray-300 shadow-xl rounded-lg" style="max-height:12rem;width:20vw">
												<div class="">
													<ul class="divide-y divide-gray-300 text-sm">
														<?php 
															foreach($variables as $var){
															?>
																<li class="p-2 hover:bg-gray-50 cursor-pointer">
																	<div class="flex justify-between">
																		<span><?php echo $var->varname; ?></span>
																		<i class="fa fa-plus text-teal-500" onclick="insertvar(this,'<?php echo $var->varname; ?>');"></i>
																	</div>
																</li>
															<?php
															}
														?>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</p>
                                <label for="message" class="absolute tracking-wide py-2 px-4 mb-4 opacity-0 leading-tight block top-0 left-0 cursor-text">Message...
                            </label>
                        </div>
					</div>
				</div>
				<!--Footer-->
				<div class="flex justify-end pt-2">
					<button
						class="focus:outline-none modal-close px-4 bg-gray-400 p-3 rounded-lg text-black hover:bg-gray-300">Cancel</button>
					<button id="but" type="submit" name="addt" class="focus:outline-none px-4 bg-teal-500 p-3 ml-3 rounded-lg text-white hover:bg-teal-400">Add Template</button>
                </div>
                </form>
			</div>
		</div>
	</div>