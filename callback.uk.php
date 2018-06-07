<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Genuine.community Order <?php echo $order_id;  ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bootstrap -->
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-2.0.3.min.js"></script> 
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>  

    <!-- x-editable (bootstrap version) -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.6/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.6/bootstrap-editable/js/bootstrap-editable.min.js"></script>
    
    <link rel="stylesheet" href="../travel/css/callback.css">
	
		
  </head>

  <body>

	<div id="tablicka" class = "wrapper">
	<div id="alert" class="alert alert-info alert-dismissible fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Увага! <?php // echo $smscode; ?></strong> При помилці данних, клікніть на помилкові данні
	</div>
	
		<div class="table">
    
			<div class="row header blue">
				<div class = "cell"> 
					Данні страхового полісу
				</div>
				<div class = "cell">
					<span name="polis_id" value="<?php echo $order_id; ?>">
						<?php echo $order_id; ?></span>
				</div>
			</div>
			 <div class = "row">
				<div class = "cell"> 
					e-mail 
				</div>
				<div class = "cell">
					<a id="email" data-placement="right"  data-title="Enter correct email" data-pk="" data-type="text"><?php echo $clients_array['0']['email']?></a>
				</div> 
			</div> 
			 <div class="row">
					<div class="cell">
						Контактний телефон:
					</div>
					<div class="cell">
						<?php echo '<a href="#" id="phone" data-type="text" data-pk="" title="Enter phone">'.$clients_array['0']['phone'].'</a>'; ?>
					</div>
			</div>
		</div>

			  <?php
//начинается треш. Берем новосозданный массив массивов $newclients и начинаем работать с каждым

foreach ($newclients as $key => $value){
	$result=array_diff($value,$tesseractclients[$key]); // сравниваем перебираемый массив с аналогичным в тесеракте по ключу.
	
	$chek = array_diff($newclients[1],$newclients[0]); // эта проверка нужна если страхователь и застрахованный одно лицо.
			
			 
	$strah = ($key == 0)?"страхувальника":"застрахованої особи $key";
	if (empty($chek) && $key == 0) 
			{
				$strah = "страхувальника / застрахованої особи 1";
				$_SESSION["strah"] = "strahzastrah";
			}
	
	

// Ну тут все понятно. Если пустой массив result и такой же тессеракт, потом ничего не выводим, если совпало страхователь и застрахованный.
	if (empty($result) && empty($tesseractclients[$key]) ) {
		
				if (count($chek)== 0 && $key == 1)
				{
				?>
 <!---</div>  DIVIIIII -->
<?php
					
				}
				else
				{ ?>

					<div class='table'>
						<div class='row header red'>
							<div class = 'cell'>
								Данні <?php echo $strah; ?> 
							</div>
							<div class = 'cell'>
								<p>Система не змогла перевірити правильність данних оскільки не були вкладені файли</p>
							</div>
						</div>
				<?php		
				//	Просто перебираются введенные пользователем данные
					
					foreach ($value as $kye => $valuee)
						{
							//здесь мы дошли до подстановки 4-х вариантов.
								switch ($kye){
								case 0:
								$field = "Ім'я";
								$xedit = "name";
								break;
								case 1:
								$field = "Прізвище";
								$xedit = "sirname";
								break;
								case 2:
								$field = "Дата народження";
								$xedit = "date_birth";
								break;
								case 3:
								$field = "Номер паспорта";
								$xedit = "passport";
								break;
								}
								
								?>

							
							<div class = "row">
								<div class = "cell"> 
									<?php echo $field;?>
								</div>
								<div class = "cell">
									<a id = "<?php echo $xedit; ?>" data-pk="<?php echo $key;?>" koss-param = "<?php echo $valuee; ?>"  data-type="text" data-title="Enter <?php echo $field ;?>" class="col-md-6" ><?php echo $valuee; ?></a>
								</div> 
							</div>
			 
						
					
					<?php
						}//end foreach		
						?>
							<div class = "row">
								<div class = "cell"> 
									ІПН
								</div>
								<div class = "cell">
									<?php echo '<a href="#" id="inn" data-type="text" data-pk="'.$key.'" title="Enter inn" class="col-md-6">'.$clients_array["$key"]["inn"].'</a>'; ?>
								</div> 
							</div>
							 </div><!-- div k table -->
						<?php
			} //end else
?> 

<?php					
	}
	// Если резултат пустой и не пустой перебираемый массив тесеракта, то ок.
	else if (empty($result) && !empty($tesseractclients[$key])){
	?>	
		<div class='table'>
			<div class='row header green'>
				<div class = 'cell'>
					Данні <?php echo $strah; ?>
				</div>
				<div class = 'cell'>
					<p>Система перевірила правильність данних. Все ОК.</p>
				</div>
			</div>
			
			<div class = "row">
				<div class = "cell"> 
					Перевірте ІПН
				</div>
				<div class = "cell">
				<?php echo '<a href="#" id="inn" data-type="text" data-pk="'.$key.'" title="Enter inn" class="col-md-6">'.$clients_array["$key"]["inn"].'</a>'; ?>
					
				</div> 
			</div>
			
	</div>  
	<?php				
	}
	// Начинаем перебор того, что не совпадает.
	else {
?>
		<div class='table'>
			<div class='row header yellow'>
				<div class = 'cell'>
					Данні <?php echo $strah; ?> 
				</div>
				<div class = 'cell'>
					<p>Система перевірила данні, перевірте на правильність</p>
				</div>
			</div>
<?php			
	//Проходим по массиву $result, который из себя представляет разницу в массивах
		foreach ($result as $kye => $valuee)
		{
			
			//здесь мы дошли до подстановки 4-х вариантов.
				switch ($kye){
				case 0:
				$field = "Ім'я";
				$xedit = "name";
				break;
				case 1:
				$field = "Фамілія";
				$xedit = "sirname";
				break;
				case 2:
				$field = "Дата народження";
				$xedit = "date_birth";
				break;
				case 3:
				$field = "Номер паспорта";
				$xedit = "passport";
				break;
				}
				
		//Генерим вывод, проходим по всем ключам распознанного
		$teseractout = (empty($tesseractclients[$key][$kye]) || $tesseractclients[$key][$kye] == "0000-00-00")?"не розпізнало :с":$tesseractclients[$key][$kye];
														/*field зависит от ключа, valuee - это значение распознанного в в массиве result*/

	?>	
		<div class = "row">
			<div class = "cell"> 
							<a id = "<?php echo $xedit; ?>" data-pk="<?php echo $key;?>"  data-type="text" data-title="Enter <?php echo $field ;?>" class="col-md-6" ><?php echo $valuee; ?></a>
	<?php //echo $field." "."<a href='#' name=".$key."--".$kye." data-type='text'  data-placement='right' data-placeholder='Required' data-title='Enter your firstname' class='editable editable-click editable-empty' data-original-title='' title=''>".$valuee."</a>";?>
			</div>
			<div class = "cell">
				розпізнало як: <input value = "<?php echo $teseractout; ?>" disabled>
			</div> 
		</div>			 
		
			 
<?php	
		}
?>
		<div class = "row">
			<div class = "cell"> 
				ІПН
			</div>
			<div class = "cell">
					<?php echo '<a href="#" id="inn" data-type="text" data-pk="'.$key.'" title="Enter inn" class="col-md-6">'.$clients_array["$key"]["inn"].'</a>'; ?>
				
			</div> 
		</div>

		
		
 </div> <!-- div k table -->
<?php
	}			
}
 ?>

</div>
		<div id="kossajax" class = "wrapper">
			<div id="smsstatus">
			</div>
			<div id="responsetext">
			</div>
			
			<div id="koss-btn-group" class="button-group form-inline">
				<label id = "labelactivate" for="activate">Перевірочний код</label>
				<input id="activate" autofocus maxlength="5">
				<button id="activate-btn" class="btn btn-primary closebutton" >Підписати</button>
				<button id="close-btn" class="btn btn-primary closebutton" >Закрити</button>
				
			</div>
		</div>	<!-- end kossajax  -->
	</div>	<!-- end wrapper  -->


	  
	  
	  
	  
<script>
$(document).ready(function() {
	
    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'inline';   


	
////////////////////////////	
	 $("#tablicka a").editable({
		type: 'text', 
		
		// anim: true,
		params:function(params){
			//params.aaa = $(this).attr('data-pk');
			params.etalon = $(this).attr('koss-param');
			return params;
		},
		
		url: '/sites/all/modules/travel/x-edit/updclient.php',
		send : 'always',
		validate: function(value) {
			if($.trim(value) == '') {
				return 'This field is required';
			}
		},
		success: function(response, newValue) {
		 console.log ("response " +response);
        //if(response == 'error') return "dddd"; //msg will be shown in editable form
			if (response.indexOf('Error') != '-1'){
				console.log ("response.indexOf(Error) " + response.indexOf('Error'))
				return response;
			}
    },	 
	 });
	//Проверяем статус смс
	var trista = 300;
	var timerId = setInterval(function() {

			var xhttp = new XMLHttpRequest();
			
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
					
					$('#smsstatus').text(this.responseText + " Чекайте на оновлення статусу " + trista) ;
					trista --;
					//console.log(this.responseText.indexOf('Error SMS code!'));						
					}
				}
				xhttp.open("POST", "api/smsstatus.php", true);
				xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhttp.send();
			}, 1000);
			
			setTimeout(function() {
			clearInterval(timerId);
			alert( 'SMS мало б надійти' );
			}, 300000);

	 /////////////////////////////////////////////////////////////
			$('#activate-btn').click(function(){

				var xhttp = new XMLHttpRequest();
			//	var verifycode = <?php echo $order_id; ?>;
				var verifycode = $('#activate').val();
				xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				clearInterval(timerId);	
					document.getElementById("responsetext").innerHTML = this.responseText;
					$('#activate').focus();
					//console.log(this.responseText.indexOf('Error SMS code!'));
					if (this.responseText.indexOf('Error SMS code!') == '-1'){
						
						
						//$('#close-btn').removeAttr('hidden');
						$('#close-btn').show("slow");
						$('#close-btn').focus();
						$('#activate').hide("fast");
						
						$('#labelactivate').hide("fast");
						// не отработал сука блять $('#activate-btn').addClass('animated hinge');
						$('#activate-btn').hide("fast");
						// $('#activate-btn').attr("hidden","true");
						// отправляем на мейл
						
						    
						
						$("#tablicka a").editable('destroy');
						$("#alert").hide("fast");	
						$('#smsstatus').hide("fast");
											
					}
				}
			};	
			xhttp.open("POST", "api/verifysms.php", true);
			xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhttp.send("checkcode" + "=" + verifycode);
		});
		//Клик на кнопку закрыть
		$('#close-btn').click(function(){
			$('#close-btn').hide("fast");
			location.replace("/")
			});

});
</script>
  </body>
</html>