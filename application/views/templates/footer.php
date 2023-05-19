			<footer class="footer footer-black footer-white">
				<div class="container-fluid"><hr>
					<div class="row">
						<div class="credits ml-auto">
							<span class="copyright">
								Extended Support Scripting<br>Copyright (&copy;) 2018-<?=getdate()['year'];?> - All rights reserved
							</span>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/perfect_scrollbar.min.js"></script>
<script src="assets/js/bootstrap_notify.min.js"></script>
<script src="assets/js/paper_dashboard.min.js"></script>
<script src="assets/js/TweenMax.min.js"></script>
<script src="assets/js/wheel_spin.min.js"></script>
<script src="assets/js/blockadblock.js"></script>
<script src="assets/js/scripts.js"></script>
<script>
function adBlockNotDetected() {
	console.log('AdBlock is not enabled');
}

function adBlockDetected() {
	console.log('AdBlock is enabled');
}

if (typeof BlockAdBlock === 'undefined') {
	adBlockDetected();
}
else {
	blockAdBlock.onDetected(adBlockDetected);
	blockAdBlock.onNotDetected(adBlockNotDetected);

	blockAdBlock.on(true, adBlockDetected);
	blockAdBlock.on(false, adBlockNotDetected);

	blockAdBlock.on(true, adBlockDetected).onNotDetected(adBlockNotDetected);
}
</script>
</html>