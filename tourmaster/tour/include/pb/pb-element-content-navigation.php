<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/

	add_action('plugins_loaded', 'tourmaster_add_pb_element_content_navigation');
	if( !function_exists('tourmaster_add_pb_element_content_navigation') ){
		function tourmaster_add_pb_element_content_navigation(){

			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('content-navigation', 'tourmaster_pb_element_content_navigation'); 
			}
			
		}
	}
	
	if( !class_exists('tourmaster_pb_element_content_navigation') ){
		class tourmaster_pb_element_content_navigation{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-plane',
					'title' => esc_html__('Content Navigation', 'tourmaster')
				);
			}
			
			// return the element options
			static function get_options(){
				return apply_filters('tourmaster_tour_item_options', array(					
					'general' => array(
						'title' => esc_html__('General', 'tourmaster'),
						'options' => array(

							'tabs' => array(
								'title' => esc_html__('Add New Tab', 'tourmaster'),
								'type' => 'custom',
								'item-type' => 'tabs',
								'wrapper-class' => 'gdlr-core-fullsize',
								'options' => array(
									'id' => array(
										'title' => esc_html__('ID', 'tourmaster'),
										'type' => 'text'
									),
									'title' => array(
										'title' => esc_html__('Title', 'tourmaster'),
										'type' => 'text'
									),
								),
								'default' => array(
									array(
										'id' => esc_html__('section-1', 'tourmaster'),
										'title' => esc_html__('Section 1', 'tourmaster'),
									),
									array(
										'id' => esc_html__('section-2', 'tourmaster'),
										'title' => esc_html__('Section 2', 'tourmaster'),
									),
								)
							),
							
						),
					),
					'style' => array(
						'title' => esc_html('Style', 'tourmaster'),
						'options' => array(
							'background-color' => array(
								'title' => esc_html__('Background Color', 'tourmaster'),
								'type' => 'colorpicker'
							),
							'enable-bottom-border' => array(
								'title' => esc_html__('Enable Bottom Border', 'tourmaster'),
								'type' => 'checkbox',
								'default' => 'disable'
							),
							'border-color' => array(
								'title' => esc_html__('Border Color', 'tourmaster'),
								'type' => 'colorpicker',
								'condition' => array( 'enable-bottom-border' => 'enable' )
							),
							'slide-bar-style' => array(
								'title' => esc_html__('Slide Bar Style', 'tourmaster'),
								'type' => 'combobox',
								'options' => array(
									'bar' => esc_html__('Bar', 'tourmaster'),
									'dot' => esc_html__('Dot', 'tourmaster')
								)
							),
							'slide-bar-color' => array(
								'title' => esc_html__('Slide Bar Color', 'tourmaster'),
								'type' => 'colorpicker'
							),
						)
					),
					'typography' => array(
						'title' => esc_html__('Typography', 'tourmaster'),
						'options' => array(
							'font-size' => array(
								'title' => esc_html__('Title Font Size', 'tourmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'font-weight' => array(
								'title' => esc_html__('Title Font Weight', 'tourmaster'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'tourmaster')
							),
							'letter-spacing' => array(
								'title' => esc_html__('Title Letter Spacing', 'tourmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'text-transform' => array(
								'title' => esc_html__('Title Text Transform', 'tourmaster'),
								'type' => 'combobox',
								'data-type' => 'text',
								'options' => array(
									'none' => esc_html__('None', 'tourmaster'),
									'uppercase' => esc_html__('Uppercase', 'tourmaster'),
									'lowercase' => esc_html__('Lowercase', 'tourmaster'),
									'capitalize' => esc_html__('Capitalize', 'tourmaster'),
								),
								'default' => 'none'
							),
						)

					),
					'spacing' => array(
						'title' => esc_html('Spacing', 'tourmaster'),
						'options' => array(
							'tab-padding' => array(
								'title' => esc_html__('Tab Padding', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'unlink' ),
							),
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'tourmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '30px'
							),
						)
					),

				));
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array() ){
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'tabs' => array(
							array(
								'id' => esc_html__('section-1', 'tourmaster'),
								'title' => esc_html__('Section 1', 'tourmaster'),
							),
							array(
								'id' => esc_html__('section-2', 'tourmaster'),
								'title' => esc_html__('Section 2', 'tourmaster'),
							),
						)
					);
				}

				$css_atts = array(
					'background-color' => empty($settings['background-color'])? '': $settings['background-color'],
					'border-color' => empty($settings['border-color'])? '': $settings['border-color'],
				);
				if( !empty($settings['enable-bottom-border']) && $settings['enable-bottom-border'] == 'enable' ){
					$css_atts['border-bottom-width'] = '1px';
					$css_atts['border-bottom-style'] = 'solid';
				}
				
				$ret  = '<div class="tourmaster-content-navigation-item-wrap clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != '30px' ){
					$ret .= tourmaster_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				$ret .= '<div class="tourmaster-content-navigation-item-outer" id="tourmaster-content-navigation-item-outer" ' . tourmaster_esc_style($css_atts) . ' >';
				$ret .= '<div class="tourmaster-content-navigation-item-container tourmaster-container" >';
				$ret .= '<div class="tourmaster-content-navigation-item tourmaster-item-pdlr" >';
				if( !empty($settings['tabs']) ){
					$active = true;
					foreach( $settings['tabs'] as $tab ){

						$id = empty($tab['id'])? '': $tab['id'];
						$title = empty($tab['title'])? '': $tab['title'];

						$ret .= '<a class="tourmaster-content-navigation-tab ';
						$ret .= ($active)? 'tourmaster-active': '';
						$ret .= '" ' . gdlr_core_esc_style(array(
							'font-size' => empty($settings['font-size'])? '': $settings['font-size'],
							'font-weight' => empty($settings['font-weight'])? '': $settings['font-weight'],
							'letter-spacing' => empty($settings['letter-spacing'])? '': $settings['letter-spacing'],
							'text-transform' => empty($settings['text-transform'])? '': $settings['text-transform'],
							'padding' => empty($settings['tab-padding'])? '': $settings['tab-padding']
						)) . 'href="#' . esc_attr($id) . '" >' . $title . '</a>';

						$active = false;
					}
				}

				if( empty($settings['slide-bar-style']) || $settings['slide-bar-style'] == 'bar' ){
					$ret .= '<div class="tourmaster-content-navigation-slider" ' . tourmaster_esc_style(array(
						'background-color' => empty($settings['slide-bar-color'])? '': $settings['slide-bar-color']
					)) . '></div>';
				}else if( $settings['slide-bar-style'] == 'dot' ){
					$ret .= '<div class="tourmaster-content-navigation-slider tourmaster-style-dot" ><span ' . tourmaster_esc_style(array(
						'background-color' => empty($settings['slide-bar-color'])? '': $settings['slide-bar-color']
					)) . ' ></span></div>';
				}
				
				$ret .= '</div>'; // tourmaster-content-navigation-item
				$ret .= '</div>'; // tourmaster-content-navigation-item-container
				$ret .= '</div>'; // tourmaster-content-navigation-item-outer
				$ret .= '</div>'; // tourmaster-content-navigation-item-wrap
				
				return $ret;
			}			
			
		} // tourmaster_pb_element_content_navigation
	} // class_exists	