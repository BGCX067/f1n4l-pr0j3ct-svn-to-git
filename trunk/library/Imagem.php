<?php
/**
 * CLASSE PARA MANIPULAÇÃO DE IMAGEM
 *
 * @author Pedro Schneider (correaschneider@gmail.com)
 */
class Imagem
{
	var $Arquivo;
	var $ColecaoDados;
	var $Recurso;
	var $Tipo;

	/**
	 * MÉTODO CONSTRUTOR
	 *
	 * @author Gibran
	 */

	function Imagem($arquivo)
	{
		if (is_file($arquivo))
		{
			$this->Arquivo = $arquivo;

			// OBTÉM OS DADOS DA IMAGEM

			$this->ColecaoDados = getimagesize($this->Arquivo);

			// CARREGA A IMAGEM DE ACORDO COM O TIPO

			switch ($this->ColecaoDados[2])
			{
				case 1:
					$this->Recurso = imagecreatefromgif($this->Arquivo);
					$this->Tipo = "image/gif";

					break;
				case 2:
					$this->Recurso = imagecreatefromjpeg($this->Arquivo);
					$this->Tipo = "image/jpeg";

					imageinterlace($this->Recurso, true);

					break;
				case 3:
					$this->Recurso = imagecreatefrompng($this->Arquivo);
					$this->Tipo = "image/png";

					imagealphablending($this->Recurso, false);
					imagesavealpha($this->Recurso, true);

					break;
				default:
					$this->ColecaoDados = null;
					$this->Recurso = null;
					$this->Tipo = null;

					return null;

					break;
			}
		}
		else
		{
			return null;
		}
	}

	/**
	 * REDIMENSIONA A IMAGEM
	 *
	 * @param integer $largura
	 * @param integer $altura
	 * @param string $modo
	 * @param array $fundo
	 *
	 * @return null
	 *
	 * @author Gibran
	 */

	function Redimencionar($largura = null, $altura = null, $modo = 2, $fundo = array(255, 255, 255, 255))
	{
		if ($this->Recurso == null && $largura > $this->ColecaoDados[0] && $altura > $this->ColecaoDados[1])
		{
			return null;
		}
		else
		{
			$medida = new stdClass();
			$posicao = new stdClass();
			$tamanho = new stdClass();

			if (empty($largura) && empty($altura))
			{
				return null;
			}
			else
			{
				// CONFIGURA O MODO

				if (in_array($modo, array(1, 2, 3)) == false)
				{
					$modo = 2;
				}

				// CONFIGURA O FUNDO

				if (is_array($fundo))
				{
					for ($indice = 0; $indice < 4; $indice += 1)
					{
						settype($fundo[$indice], "integer");

						if ($fundo[$indice] < 0)
						{
							$fundo[$indice] = 0;
						}
						else if ($fundo[$indice] > 255)
						{
							$fundo[$indice] = 255;
						}
					}
				}
				else
				{
					$fundo = array(255, 255, 255, 0);
				}

				$fundo[3] = round(($fundo[3] * 127) / 255, 0);

				// CALCULA O REDIMENSIONAMENTO DA IMAGEM DE ACORDO COM O MÉTODO

				if (empty($largura) || empty($altura))
				{
					$modo = null;

					if (empty($largura))
					{
						$medida->Largura = round(($this->ColecaoDados[0] * $altura) / $this->ColecaoDados[1], 0);
						$medida->Altura = $altura;
					}
					else
					{
						$medida->Largura = $largura;
						$medida->Altura = round(($this->ColecaoDados[1] * $largura) / $this->ColecaoDados[0], 0);
					}

					$posicao->esquerda = 0;
					$posicao->topo = 0;

					$tamanho = $medida;
				}
				else
				{
					$medida->Largura = round(($this->ColecaoDados[0] * $altura) / $this->ColecaoDados[1], 0);
					$medida->Altura = round(($this->ColecaoDados[1] * $largura) / $this->ColecaoDados[0], 0);
				}

				switch ($modo)
				{
					// CAIXA
					case 1:
						if ($medida->Altura < $altura)
						{
							$medida->Largura = $largura;

							$posicao->esquerda = 0;
							$posicao->topo = round(($altura - $medida->Altura) / 2, 0);
						}
						else
						{
							$medida->Altura = $altura;

							$posicao->esquerda = round(($largura - $medida->Largura) / 2, 0);
							$posicao->topo = 0;
						}

						$tamanho->Largura = $largura;
						$tamanho->Altura = $altura;

						break;
					// SIMPLES
					case 2:
						if ($medida->Altura < $altura)
						{
							$medida->Largura = $largura;
						}
						else
						{
							$medida->Altura = $altura;
						}

						$posicao->esquerda = 0;
						$posicao->topo = 0;

						$tamanho = $medida;

						break;
					// CORTE
					case 3:
						if ($medida->Altura < $altura)
						{
							$medida->Altura = $altura;

							$posicao->esquerda = round(($largura - $medida->Largura) / 2, 0);
							$posicao->topo = 0;
						}
						else
						{
							$medida->Largura = $largura;

							$posicao->esquerda = 0;
							$posicao->topo = round(($altura - $medida->Altura) / 2, 0);
						}

						$tamanho->Largura = $largura;
						$tamanho->Altura = $altura;

						break;
				}

				// INICILIZA E REDIMENSIONA A IMAGEM

				$recurso = imagecreatetruecolor($tamanho->Largura, $tamanho->Altura);
				imagefill($recurso, 0, 0, imagecolorallocatealpha($recurso, $fundo[0], $fundo[1], $fundo[2], $fundo[3]));

				if($this->Tipo !== 'image/jpeg')
				{
					imagealphablending($recurso, false);
					imagesavealpha($recurso, true);
				}


				imagecopyresampled($recurso, $this->Recurso, $posicao->esquerda, $posicao->topo, 0, 0, $medida->Largura, $medida->Altura, $this->ColecaoDados[0], $this->ColecaoDados[1]);


				$this->Ponteiro = $recurso;
			}
		}
	}

	/**
	 * SALVA A IMAGEM
	 *
	 * @param string $tipo
	 * @param string $arquivo
	 * @param integer $qualidade
	 *
	 * @return null
	 *
	 * @author Gibran
	 */

	function Salvar($arquivo = null)
	{
		if ($this->Ponteiro == null)
		{
			return null;
		}
		else
		{
			// EXPORTA A IMAGEM

			switch ($this->Tipo)
			{
				case "image/gif":
					imagegif($this->Ponteiro, $arquivo);

					break;
				case "image/jpeg":
					imagejpeg($this->Ponteiro, $arquivo, 95);

					break;
				case "image/png":
					imagepng($this->Ponteiro, $arquivo);

					break;
			}
		}
	}

	/*
	 * Exibe a imagem no navegador
	 */
	function Exibir()
	{
		if ($this->Ponteiro == null)
		{
			return null;
		}
		else
		{
			// EXPORTA A IMAGEM
			header("Content-type: ".$this->Tipo);
			switch ($this->Tipo)
			{
				case "image/gif":

					imagegif($this->Ponteiro);

					break;
				case "image/jpeg":
					imagejpeg($this->Ponteiro, NULL, 95);

					break;
				case "image/png":
					imagepng($this->Ponteiro);

					break;
			}
		}
	}

	/**
	 * Elimina o recurso.
	 *
	 */
	function Destruir()
	{
		imagedestroy($this->Ponteiro);
		imagedestroy($this->Recurso);
	}
}
?>