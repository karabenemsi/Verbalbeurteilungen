<?php
echo '
				<footer>
		
					<div class="footercontent">
						<img src="//' . $hostname . '/pictures/site/Footer/Logo_FCG_003_400.png" width="100" alt="FlowR Logo" ><p>FlowR Coding</p>
					</div>
					<div class="footercontent">
						<p><span id="copyright">Copyright: Marcel Killinger, Florian Lubitz, Leander Eger</span></p>
					</div>
					<div class="footercontent">
						<p>
							
    							<img style="border:0;width:88px;height:31px"
       							 src="http://' .$hostname . '/pictures/site/Footer/vcss-blue.gif"
       							alt="CSS ist valide!" />
   							
						</p>
					</div>
		
		
				</footer>
			</div>
		</div>
	
	</body>
</html>
'
?>
<?php 		mysqli_close($db);
?>