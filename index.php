<?php
$tmp = array(
	'ec' 	=>	'Encoberto com Chuvas Isoladas',
	'ci' 	=>	'Chuvas Isoladas',
	'c' 	=> 'Chuva',
	'in' 	=>	'Instável',
	'pp' 	=>	'Poss. de Pancadas de Chuva',
	'cm' 	=>	'Chuva pela Manhã',
	'cn' 	=>	'Chuva a Noite',
	'pt' 	=>	'Pancadas de Chuva a Tarde',
	'pm' 	=>	'Pancadas de Chuva pela Manhã',
	'np' 	=>	'Nublado e Pancadas de Chuva',
	'pc' 	=>	'Pancadas de Chuva',
	'pn' 	=>	'Parcialmente Nublado',
	'cv' 	=>	'Chuvisco',
	'ch' 	=>	'Chuvoso',
	't' 	=> 'Tempestade',
	'ps' 	=>	'Predomínio de Sol',
	'e' 	=> 'Encoberto',
	'n' 	=>	'Nublado',
	'cl' 	=> 'Céu Claro',
	'nv' 	=>	'Nevoeiro',
	'g' 	=>	'Geada',
	'ne' 	=>	'Neve',
	'nd' 	=>	'Não Definido',
	'pnt' 	=>	'Pancadas de Chuva a Noite',
	'psc' 	=>	'Possibilidade de Chuva',
	'pcm'	=>	'Possibilidade de Chuva pela Manhã',
	'pct'	=>	'Possibilidade de Chuva a Tarde',
	'pcn'	=>	'Possibilidade de Chuva a Noite',
	'npt'	=>	'Nublado com Pancadas a Tarde',
	'npn'	=>	'Nublado com Pancadas a Noite',
	'ncn'	=>	'Nublado com Poss. de Chuva a Noite',
	'nct'	=>	'Nublado com Poss. de Chuva a Tarde',
	'ncm'	=>	'Nubl. c/ Poss. de Chuva pela Manhã',
	'npm'	=>	'Nublado com Pancadas pela Manhã',
	'npp'	=>	'Nublado com Possibilidade de Chuva',
	'vn'	=>	'Variação de Nebulosidade',
	'ct'	=>	'Chuva a Tarde',
	'ppn'	=>	'Poss. de Panc. de Chuva a Noite',
	'ppt'	=>	'Poss. de Panc. de Chuva a Tarde',
	'ppm'	=>	'Poss. de Panc. de Chuva pela Manhã'
);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Consultar Clima</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<br><br>
				<form method="POST">
					<input type="text" name="cidade" class="form-control" autofocus="">
					<br>
					<button class="btn btn-success btn-block btn-lg">Consultar</button>
				</form>
				<?php
				if (!empty($_POST['cidade'])) {
					echo '<hr>';
					$cidade = addslashes($_POST['cidade']);

					$url = 'http://servicos.cptec.inpe.br/XML/listaCidades?city='.$cidade;

					$xml = simplexml_load_file($url);

					if ($xml == true) {
						$id = $xml->cidade->id;
						$uf = $xml->cidade->uf;
						$municipio = $xml->cidade->nome;

						$previsao = 'http://servicos.cptec.inpe.br/XML/cidade/'.$id.'/previsao.xml';

						$xml2 = simplexml_load_file($previsao);

						$data = $xml2->previsao->dia;
						$mimina = $xml2->previsao->minima;
						$maxima = $xml2->previsao->maxima;
						$tempo = $xml2->previsao->tempo;
						$iuv = $xml2->previsao->iuv;

						?>
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Cidade</th>
										<th>UF</th>
										<th>Data</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?=$municipio; ?></td>
										<td><?=$uf; ?></td>
										<td><?=date('d/m/Y', strtotime($data)); ?></td>
									</tr>
								</tbody>
								<thead>
									<tr>
										<th>Minima</th>
										<th colspan="2">Maxima</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?=$xml2->previsao->minima; ?></td>
										<td colspan="2"><?=$maxima; ?></td>
									</tr>
								</tbody>
								<thead>
									<tr>
										<th colspan="3">Maxima Diaria de Raios Ultravioleta</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="3"><?=$iuv; ?></td>
									</tr>
								</tbody>
								<thead>
									<tr>
										<th colspan="3">Tempo</th>
									</tr>
								</thead>
								<tbody>
									<tr>
								<?php
								//TEMPO DA CIDADE
								foreach ($tmp as $key => $value):
									if ($key == $tempo):
										echo '<td colspan="3">'.$value.'</td>';
									endif;
								endforeach;
								?>
									</tr>
								</tbody>
							</table>
						</div>
						<?php
						
					} else {
						echo 'Cidade não encontrada';
					}
				}
				?>
			</div>
			<div class="col-sm-3"></div>
		</div>
	</div>

</body>
</html>
