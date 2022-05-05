<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/sources/LuksushuseParser.php';

class Parser {

	private $source;

	public string $url;
	public string $title;
	public string $price;
	public string $description;
	public string $excerpt;
	public string $image;

	public function __construct( $url ) {
		$this->url    = $url;
		$this->source = $this->sourceSelector( $url );
	}

	public function run(): void {
		if ( $this->source == 'error' ) {
			$this->errorMessage();

			return;
		}

		if ( $this->source == 'luksushuse.dk' ) {
			$this->view( new LuksushuseParser( $this->url ) );
		}
	}

	public function view( $data ): void { ?>
        <div style="display: flex">
            <ul style="list-style: disc; padding-left: 20px; flex: 1;">
                <li><strong>Url: </strong><?php echo $data->url ?></li>
                <li><strong>Source: </strong><?php echo $data->source ?></li>
                <li><strong>Title: </strong><?php echo $data->title ?></li>
                <li><strong>Price: </strong><?php echo $data->price ?></li>
                <li><strong>Description: </strong><?php echo $data->description ?></li>
                <li><strong>Excerpt: </strong><?php echo $data->excerpt ?></li>
                <li><strong>Image: </strong><?php echo $data->image ?></li>
            </ul>

            <img src="<?php echo $data->image ?>" alt="<?php echo $data->title ?>" style="max-width: 40%;">
        </div>

	<?php }

	private function sourceSelector( $url ): string {
		$source = 'error';
		if ( stripos( $url, 'luksushuse.dk' ) !== false ) {
			$source = 'luksushuse.dk';
		}
		if ( stripos( $url, 'dancenter.dk' ) !== false ) {
			$source = 'dancenter.dk';
		}
		if ( stripos( $url, 'feriehusudlejning.dk' ) !== false ) {
			$source = 'feriehusudlejning.dk';
		}

		return $source;
	}

	private function errorMessage(): void {
		echo '<p style="color: red;"><strong>ERROR: </strong> is no parser for this link</p>';
	}
}

$data = new Parser( $_POST['url'] );
$data->run();
