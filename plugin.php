<?php

class pluginPosters extends Plugin 
{
	/**
	 * 
	 */
	public function init( )
	{
		// Fields and default values for the database of this plugin
		$this->dbFields = [
			'width'             => 1000,
			'height'            => 250,
			'bg_color'          => '#000000',
			'bg_color_2'        => '',
			'bg_color_3'        => '',
			'bg_color_4'        => '',
			'mixed_bg_colors'   => 'no',
			'bg_image'          => '',
			'overlay_color'     => '',
			'align'             => 'center',
			'font'			    => '',
			'font_size'		    => '34',
			'font_color'        => '#FFFFFF',
			'font_stroke_color' => '',
			'regenerate_all'    => 'no',
		];
	}

	/**
	 * Method called on the settings of the plugin on the admin area
	 */
	public function form( )
	{
		global $L;

		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $this->description( );
		$html .= '</div>';
		
		/**
		 * 
		 */
		$html .= '<table>';
		$html .= '<tr>';
		$html .=    '<td><label>' . $L->get( 'Width' ) . '</label></td>';
		$html .=    '<td><label>' . $L->get( 'Height' ) . '</label></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .=    '<td><input type="number" name="width" value="' . $this->getValue( 'width' ) . '"></td>';
		$html .=    '<td><input type="number" name="height" value="' . $this->getValue( 'height' ) . '"></td>';
		$html .= '</tr>';
		$html .= '</table>';

		/**
		 * 
		 */
		$html .= '<div>';
		$html .= '<label>' . $L->get( 'Background Color or Gradient' ) . '</label>';
		$html .=    '<input type="color" name="bg_color" value="' . $this->getValue( 'bg_color' ) . '">';
		$html .=    '<input type="color" name="bg_color_2" value="' . $this->getValue( 'bg_color_2' ) . '">';
		$html .=    '<input type="color" name="bg_color_3" value="' . $this->getValue( 'bg_color_3' ) . '">';
		$html .=    '<input type="color" name="bg_color_4" value="' . $this->getValue( 'bg_color_4' ) . '">';
		$html .= '</div>';
		
		/**
		 * 
		 */
		$html .= '<div>';
		$html .= '<label>' . $L->get( 'Mixed Background Colors' ) . '</label>';
		$html .=    '<select name="mixed_bg_colors">';
		foreach( [ 'yes', 'no' ] as $state ) { $html .= '<option value="' . $state . '"' . ( $this->getValue( 'mixed_bg_colors' ) === $state ? ' selected' : '' ) . '>' . ucfirst( $state ) . '</option>'; }
		$html .=    '</select>';
		$html .= '</div>';

		/**
		 * 
		 */
		$html .= '<div>';
		$html .= '<label>' . $L->get( 'Background Image' ) . '</label>';
		$html .=    '<input type="text" name="bg_image" value="' . $this->getValue( 'bg_image' ) . '" placeholder="https://">';
		$html .=    '<span class="tip">' . $L->get( 'Image URL' ) . '</span>';
		$html .= '</div>';
		
		/**
		 * 
		 */
		$html .= '<div>';
		$html .=    '<label>' . $L->get( 'Overlay Color' ) . '</label>';
		$html .=    '<input type="color" name="overlay_color" value="' . $this->getValue( 'overlay_color' ) . '">';
		$html .= '</div>';
		
		/**
		 * 
		 */
		$html .= '<table>';
		$html .= '<tr>';
		$html .=    '<td><label>' . $L->get( 'Font' ) . '</label></td>';
		$html .=    '<td><label>' . $L->get( 'Size' ) . '</label></td>';
		$html .=    '<td><label>' . $L->get( 'Color' ) . '</label></td>';
		$html .=    '<td><label>' . $L->get( 'Stroke' ) . '</label></td>';
		$html .= '</tr>';
		$html .= '<tr style="padding: 0 10px; text-align: center;">';
		$html .=    '<td>';
		$html .=        '<select name="font">';
		foreach( glob( __DIR__ . "/fonts/*.{ttf,otf}", GLOB_BRACE ) as $filePath )
		{
			$fileName = basename( $filePath );
			$html .= '<option value="' . $fileName . '"' . ( $this->getValue( 'font' ) === $fileName ? ' selected' : '' ) . '>' . $fileName . '</option>'; 
		}
		$html .=        '</select>';
		$html .=    '</td>';
		$html .=    '<td>';
		$html .=        '<input type="number" name="font_size" value="' . $this->getValue( 'font_size' ) . '">';
		$html .=    '</td>';
		$html .=    '<td>';
		$html .=        '<input type="color" name="font_color" value="' . $this->getValue( 'font_color' ) . '">';
		$html .=    '</td>';
		$html .=    '<td>';
		$html .=        '<input type="color" name="font_stroke_color" value="' . $this->getValue( 'font_stroke_color' ) . '">';
		$html .=    '</td>';
		$html .= '</tr>';
		$html .= '</table>';
		
		/**
		 * 
		 */
		$html .= '<div>';
		$html .=    '<label>' . $L->get( 'Text Align' ) . '</label>';
		$html .=    '<select name="align">';
		foreach( [ 'left', 'center', 'right', 'random' ] as $align ) 
		{ 
			$html .= '<option value="' . $align . '"' . ( $this->getValue( 'align' ) === $align ? ' selected' : '' ) . '>' . ucfirst( $align ) . '</option>'; 
		}
		$html .=    '</select>';
		$html .= '</div>';
		
		/**
		 * 
		 */
		$html .= '<hr />';
		
		/**
		 * 
		 */
		$html .= '<div>';
		$html .=    '<label>' . $L->get( 'Regenerate All Posters' ) . '</label>';
		$html .=    '<select name="regenerate_all">';
		foreach( [ 'yes', 'no' ] as $state ) { $html .= '<option value="' . $state . '"' . ( $this->getValue( 'regenerate_all' ) === $state ? ' selected' : '' ) . '>' . ucfirst( $state ) . '</option>'; }
		$html .=    '</select>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * 
	 */
	public function generateForAll( )
	{
		global $pages;

		$list = $pages->getList( 1, -1, false );
		
		foreach( $list as $pageID ) 
		{
			$this->generate( $pageID );
		}
	}

	/**
	 * 
	 */
	public function generate( $pageID )
	{
		global $pages;
		
		//
		$page = buildPage( $pageID );
		$coverImage = $page->coverImage( true );
		$text = !empty( $page->description( ) ) ? $page->description( ) : $page->title( );
		
		//
		if( ( !empty( $coverImage ) && strpos( $coverImage, $this->workspace( ) ) < 0 ) 
			|| empty( $this->getValue( 'font' ) ) 
			|| empty( $text ) )
		{
			return;
		}
		
		/**
		 * 
		 */
		require_once 'vendor/poster-gen/src/Helpers.php';
		require_once 'vendor/poster-gen/src/Options.php';
		require_once 'vendor/poster-gen/src/Utils.php';
		require_once 'vendor/poster-gen/src/Draw.php';
		require_once 'vendor/poster-gen/src/PosterGen.php';

		/**
		 * 
		 */
		if( $this->getValue( 'align' ) === 'random' )
		{ 
			$alignArray = [ 'left', 'center', 'right' ];
			$align = $alignArray[ array_rand( $alignArray, 1 ) ]; 
		}
		else
		{
			$align = $this->getValue( 'align' );
		}

		/**
		 * 
		 */
		$poster = ( new \PosterGen\PosterGen( [ ] ) )
					->setSize( $this->getValue( 'width' ), $this->getValue( 'height' ) )
					->setVerticalPadding( 30 )
					->setHorizontalPadding( 30 )
					->setBackgroundColor( $this->getValue( 'bg_color' ) )
					->setVerticalAlignment( 'center' )
					->setHorizontalAlignment( $align )
					->setFont( __DIR__ . '/fonts/' . $this->getValue( 'font' ) )
					->setFontColor( $this->getValue( 'font_color' ) )
					->setFontSize( $this->getValue( 'font_size' ) );
		
		/**
		 * 
		 */
		if( !empty( $this->getValue( 'bg_image' ) ) )
		{
			$poster->setBackgroundImage( $this->getValue( 'bg_image' ) );
		}		
		/**
		 * 
		 */
		else if( !empty( $this->getValue( 'bg_color_2' ) )
				|| !empty( $this->getValue( 'bg_color_3' ) )
				|| !empty( $this->getValue( 'bg_color_4' ) ))
		{
			$gradientColors = [
				$this->getValue( 'bg_color' ),
				$this->getValue( 'bg_color_2' ),
				$this->getValue( 'bg_color_3' ),
				$this->getValue( 'bg_color_4' )
			];
			
			//
			if( $this->getValue( 'mixed_bg_colors' ) === 'yes' ) { shuffle( $gradientColors ); }
			
			//
			$poster->setBackgroundGradient( $gradientColors );
		}			

		/**
		 * 
		 */
		if( !empty( $this->getValue( 'overlay_color' ) ) && $this->getValue( 'overlay_color' ) !== '#000000' )
		{
			$poster->setOverlayColor( $this->getValue( 'overlay_color' ), 60 );
		}
		
		/**
		 * 
		 */
		if( !empty( $this->getValue( 'font_stroke_color' ) ) && $this->getValue( 'font_stroke_color' ) !== '#000000' )
		{
			$poster->setFontStroke( $this->getValue( 'font_stroke_color' ), 1 );
		}
		
		/**
		 * 
		 */
		$imageName = md5( $pageID ) . '.png';
		$imagePath = PATH_UPLOADS . $imageName;
		file_put_contents( $imagePath, $poster->addText( $text )->output( 'png' ) );

		/**
		 * 
		 */
		$tags = $page->tags( ); 
		 
		 
		 /**
		  * 
		  */
		$pages->edit( array_replace_recursive( $page->getDB( ), [
			'content'       => $page->contentRaw( ),
			'parent'        => $page->parent( ),
			'slug'          => $page->slug( ),
			'tags'          => $page->tags( ),
			'coverImage'    => strtr( $imagePath, [ PATH_UPLOADS => '' ] )
		] ) );
	}

	/**
	 * 
	 */
	public function post( ) 
	{
		$state = parent::post( );
		
		/**
		 * 
		 */
		if( $state && $this->getValue( 'regenerate_all' ) === 'yes' )
		{
			$this->generateForAll( );
		}
		
		return $state;
	}

	/**
	 * 
	 */
	public function afterPageModify( ) 
	{
		global $url;

		/**
		 * 
		 */
		preg_match( '/^edit-content\/(.*?)$/', $url->slug( ), $URLMatches );
		$pageKey = $URLMatches[ 1 ]; 

		/**
		 * 
		 */
		$this->generate( $pageKey );
	}
	
	/**
	 * 
	 */
	public function afterPageDelete( ) 
	{
		
	}
}