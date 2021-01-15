    <div class="main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster"
		style="background: rgba(0,0,0,.7);display:none">
		<div
			class="border border-teal-500 shadow-lg modal-container bg-white w-11/12 md:max-w-4xl mx-auto rounded shadow-lg z-50 overflow-y-auto">
			<div class="modal-content py-4 text-left px-6">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
				<!--Title-->
				<div class="flex justify-between items-center pb-3">
					<p class="text-2xl font-bold">SMS Blaster</p>
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
					<p>SMS type:<span class="mx-20"></span><input type="radio" name="type" id="contact" value="isContact" checked /><label for="contact">Contact</label><span class="mx-10"></span><input type="radio" id="billing" name="type" value="isBilling"><label for="billing">Billing</label></p>
					<p class="pt-5">Recipients:</p>
                    <p class="text-blue-500" id="recipients"></p>
                    <input type="hidden" id="ids" name="ids" />
                    <!-- Message field -->
                    <div class="flex flex-wrap my-6">
                        <div class="relative w-full appearance-none label-floating">
                            <textarea oninput="updateCost()" maxlength="640" rows="4" id="message" class="autoexpand tracking-wide py-2 px-4 mb-3 leading-relaxed appearance-none block w-full bg-gray-200 border border-gray-200 rounded focus:outline-none focus:bg-white focus:border-gray-500"
								id="message" type="text" name="message" placeholder="Message..."></textarea>
								<p>
									<div class="flex justify-between items-baseline p-3">
										<div>Credit cost per sms: <span id="cost" class="text-teal-700"></span></div>
										<span class="text-teal-500" onclick="this.parentNode.nextElementSibling.classList.remove('hidden')" >Insert Variable</span>
									</div>
									<div class="relative hidden">
										<div class="absolute p-3" style="right:1rem;z-index:9999">
											<div class="flex justify-center overflow-auto bg-gray-300 shadow-xl rounded-lg" style="max-height:12rem;width:20vw">
												<div class="">
													<ul class="divide-y divide-gray-300 text-sm">
														<?php 
															foreach($variables as $var){
															?>
																<li class="p-2 hover:bg-gray-50 cursor-pointer">
																	<div class="flex justify-between">
																		<span><?php echo $var->varname; ?></span>
																		<i class="fa fa-plus" onclick="this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.classList.add('hidden')"></i>
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
					<p><div class="flex justify-between	items-baseline p-3">
						<label class="inline-flex items-center mt-3">
							<input type="checkbox" class="form-checkbox h-5 w-5 text-purple-600" id="usetemplate" onchange="templated();"><span class="ml-2 text-gray-700">Use Template?</span>
						</label>
						<a class="text-blue-500" href='public.php?templating'>Manage SMS Templates</a>
					</div></p>
					<!-- basic select -->
					<?php
						include_once 'select.php';
						select($templates);
					?>
				</div>
				<!--Footer-->
				<div class="flex justify-end pt-2">
					<button
						class="focus:outline-none modal-close px-4 bg-gray-400 p-3 rounded-lg text-black hover:bg-gray-300">Cancel</button>
					<button type="submit" name="submit" id="sendbutton"
						class="focus:outline-none px-4 bg-teal-500 p-3 ml-3 rounded-lg text-white hover:bg-teal-400">Send</button>
                </div>
                </form>
			</div>
		</div>
	</div>