<?php
namespace BlankElementsPro\Modules\EmbedYoutube\Widgets;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;
class Embed_Youtube extends Widget_Base {
	
	public function get_name() {
		return 'blank-embed-youtube';
	}

	public function get_title() {
		return __( 'Embed Youtube', 'blank-elements-pro' );
	}

	public function get_icon() {
		return 'fa fa-youtube';
	}

	public function get_categories() {
		return [ 'configurator-template-kits-blocks-pro-widgets' ];
	}
	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Youtube Iframe', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'urls',
			[
				'label' => __( 'URL', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => __( 'https://www.youtube.com/watch?v=NpEaa2P7qZI', 'blank-elements-pro' ),
			]
		);
		$this->add_control(
			'iframe_width',
			[
				'label' => __( 'Width', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXT,
				'input_type' => 'number',
				'placeholder' => __( '', 'blank-elements-pro' ),
			]
		);
		$this->add_control(
			'iframe_height',
			[
				'label' => __( 'Height', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXT,
				'input_type' => 'number',
				'placeholder' => __( '', 'blank-elements-pro' ),
			]
		);
		
		$this->end_controls_section();
		$this->start_controls_section(
            'yt_control_settings',
            [
                'label'                 => __( 'Controls', 'blank-elements-pro' ),
            ]
        );
		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'blank-elements-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no'  => __( 'No', 'blank-elements-pro' ),
					'yes' => __( 'Yes', 'blank-elements-pro' ),
				],
			]
		);
		$this->add_control(
			'accelerometerutoplay',
			[
				'label' => __( 'Accelerometer', 'blank-elements-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no'  => __( 'No', 'blank-elements-pro' ),
					'yes' => __( 'Yes', 'blank-elements-pro' ),
				],
			]
		);
		$this->end_controls_section();


		// add advance Display Conditions
		$this->start_controls_section(
			'blank_element_advanced',
			[
				'label' => __( 'Blank Element Rules', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);
		$this->add_control(
			'blank_element_condition',
			[
				'label' => __( 'Rule Condition', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'options' => [
					'yes' => __( 'Yes', 'blank-elements-pro' ),
					'no' => __( 'No', 'blank-elements-pro' ),
				],
				'default' => 'no'
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'condition_key',
			[
				'type' => Controls_Manager::SELECT,
				'label_block'=>true,
				'default' => 'authentication',
				'show_label' => false,
				'options' => [
					// User
					'authentication'  => _( 'Login Status', 'blank-elements-pro' ),
					'user'  => _( 'Current User', 'blank-elements-pro' ),
					'role'  => _( 'User Role', 'blank-elements-pro' ),
				],	
		
			]
		);
		$repeater->add_control(
			'is_not',
			[
				'type' => Controls_Manager::SELECT,
				'label_block'=>true,
				'default' => 'is',
				'show_label' => false,
				'options' => [
					'is'  => _( 'Is', 'blank-elements-pro' ),
					'is_not'  => _( 'Is Not', 'blank-elements-pro' ),
				],	
		
			]
		);
		$repeater->add_control(
			'is_login',
			[
				'type' => Controls_Manager::SELECT,
				'label_block'=>true,
				'default' => 'authenticated',
				'condition' => [
					'condition_key' => 'authentication'
				],
				'show_label' => false,
				'options' => [
					'authenticated'  => _( 'Logged in', 'blank-elements-pro' ),
				],	
		
			]
		);
		$repeater->add_control(
			'current_user',
			[
				'type' => Controls_Manager::TEXT,
				'label_block'=>true,
				'condition' => [
					'condition_key' => 'user'
				],
				'show_label' => false,
				'placeholder' => __( 'Current User', 'blank-elements-pro' ),
		
			]
		);

		$repeater->add_control(
			'user_role',
			[
				'type' => Controls_Manager::SELECT,
				'label_block'=>true,
				'default' => 'subscriber',
				'condition' => [
					'condition_key' => 'role'
				],
				'show_label' => false,
				'options' => [
					'administrator'  => _( 'Administrator', 'blank-elements-pro' ),
					'editor'  => _( 'Editor', 'blank-elements-pro' ),
					'author'  => _( 'Author', 'blank-elements-pro' ),
					'contributor'  => _( 'Contributor', 'blank-elements-pro' ),
					'subscriber'  => _( 'Subscriber', 'blank-elements-pro' )
				],	
		
			]
		);

		$this->add_control(
			
			'condition_list',
			[
				'label' => __( '', 'blank-elements-pro' ),
				'type' => Controls_Manager::REPEATER,
				'condition' => [
					'blank_element_condition' => 'yes'
				],
				'fields' => $repeater->get_controls(),
				'item_actions' => [
					'add'       => false,
					'duplicate' => false,
					'remove'    => false,
					'sort'      => true,
				],
				'default' => [
					
					'condition_key' =>__( 'authentication', 'blank-elements-pro' ),

				],
				'title_field' => 'Rule',
			]
		);
		$this->end_controls_section();
	}
		protected function render() {

			$settings = $this->get_settings_for_display();
			$html = wp_oembed_get( $settings['urls'] );
			$show_html = ($settings['blank_element_output_html']=='yes') ? 'd-none' : 'display';

			echo '<div class="embed-youtube-elementor-widget">';
			if($settings['blank_element_condition']=='yes'){
				$rule_condtion = ($settings['display_on']=='all')? '&&': '||';
				foreach (  $settings['condition_list'] as $item ) {
				switch ($item['condition_key']) {
					case 'authentication':
						if($item['is_not']=='is' && is_user_logged_in()){
								echo '<iframe src="'.str_replace("watch?v=","embed/",($settings['urls']) ? $settings['urls']:'https://www.youtube.com/watch?v=NpEaa2P7qZI').'"';//convert youtube watch url to embed
								echo  ($settings['iframe_width']) ? 'width="'.$settings['iframe_width'].'"' : 'width="516"' ;//iframe width
								echo  ($settings['iframe_height']) ? 'height="'.$settings['iframe_height'].'"' : 'height="315"' ;//iframe height
								echo 'allow="';
								echo ($settings['autoplay']=='no') ? '': 'autoplay' ; //autoplay
								echo '"';
								echo '>';
								echo '</iframe>';
						}elseif($item['is_not']=='is_not'){
							echo '<iframe src="'.str_replace("watch?v=","embed/",($settings['urls']) ? $settings['urls']:'https://www.youtube.com/watch?v=NpEaa2P7qZI').'"';//convert youtube watch url to embed
							echo  ($settings['iframe_width']) ? 'width="'.$settings['iframe_width'].'"' : 'width="516"' ;//iframe width
							echo  ($settings['iframe_height']) ? 'height="'.$settings['iframe_height'].'"' : 'height="315"' ;//iframe height
							echo 'allow="';
							echo ($settings['autoplay']=='no') ? '': 'autoplay' ; //autoplay
							echo '"';
							echo '>';
							echo '</iframe>';
						}
						break;
					case 'user':
						global $current_user;
						wp_get_current_user();
						$current_user = $current_user->user_login;
						    if($item['is_not']=='is'){
								if($current_user==$item['current_user']){
									echo '<iframe src="'.str_replace("watch?v=","embed/",($settings['urls']) ? $settings['urls']:'https://www.youtube.com/watch?v=NpEaa2P7qZI').'"';//convert youtube watch url to embed
									echo  ($settings['iframe_width']) ? 'width="'.$settings['iframe_width'].'"' : 'width="516"' ;//iframe width
									echo  ($settings['iframe_height']) ? 'height="'.$settings['iframe_height'].'"' : 'height="315"' ;//iframe height
									echo 'allow="';
									echo ($settings['autoplay']=='no') ? '': 'autoplay' ; //autoplay
									echo '"';
									echo '>';
									echo '</iframe>';
								}
							}elseif($item['is_not']=='is_not'){
								if($current_user!=$item['current_user']){
									echo '<iframe src="'.str_replace("watch?v=","embed/",($settings['urls']) ? $settings['urls']:'https://www.youtube.com/watch?v=NpEaa2P7qZI').'"';//convert youtube watch url to embed
									echo  ($settings['iframe_width']) ? 'width="'.$settings['iframe_width'].'"' : 'width="516"' ;//iframe width
									echo  ($settings['iframe_height']) ? 'height="'.$settings['iframe_height'].'"' : 'height="315"' ;//iframe height
									echo 'allow="';
									echo ($settings['autoplay']=='no') ? '': 'autoplay' ; //autoplay
									echo '"';
									echo '>';
									echo '</iframe>';
								}
							}
						break;
					case 'role':
						$user_meta = get_userdata(get_current_user_id());
						$user_roles=$user_meta->roles;

						// Check if the role you're interested in, is present in the array.
						if($user_roles){
							if ( in_array( 'administrator', $user_roles, true ) ) {
								$user_role = 'administrator';
							}else if(in_array( 'editor', $user_roles, true )){
								$user_role = 'editor';
							}else if(in_array( 'author', $user_roles, true )){
								$user_role = 'author';
							}else if(in_array( 'contributor', $user_roles, true )){
								$user_role = 'contributor';
							}else if(in_array( 'subscriber', $user_roles, true )){
								$user_role = 'subscriber';
							}
						}
						
						
						//echo $user_role;
						if($item['is_not']=='is'){
							if($item['user_role']==$user_role){
								echo '<iframe src="'.str_replace("watch?v=","embed/",($settings['urls']) ? $settings['urls']:'https://www.youtube.com/watch?v=NpEaa2P7qZI').'"';//convert youtube watch url to embed
								echo  ($settings['iframe_width']) ? 'width="'.$settings['iframe_width'].'"' : 'width="516"' ;//iframe width
								echo  ($settings['iframe_height']) ? 'height="'.$settings['iframe_height'].'"' : 'height="315"' ;//iframe height
								echo 'allow="';
								echo ($settings['autoplay']=='no') ? '': 'autoplay' ; //autoplay
								echo '"';
								echo '>';
								echo '</iframe>';
							}
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
								echo '<iframe src="'.str_replace("watch?v=","embed/",($settings['urls']) ? $settings['urls']:'https://www.youtube.com/watch?v=NpEaa2P7qZI').'"';//convert youtube watch url to embed
								echo  ($settings['iframe_width']) ? 'width="'.$settings['iframe_width'].'"' : 'width="516"' ;//iframe width
								echo  ($settings['iframe_height']) ? 'height="'.$settings['iframe_height'].'"' : 'height="315"' ;//iframe height
								echo 'allow="';
								echo ($settings['autoplay']=='no') ? '': 'autoplay' ; //autoplay
								echo '"';
								echo '>';
								echo '</iframe>';

							}
						}

						break;
					default:
						echo $item['condition_key'].' condition need to set up';
						break;
				}

					  
				}

			}else{
			echo '<iframe src="'.str_replace("watch?v=","embed/",($settings['urls']) ? $settings['urls']:'https://www.youtube.com/watch?v=NpEaa2P7qZI').'"';//convert youtube watch url to embed
			echo  ($settings['iframe_width']) ? 'width="'.$settings['iframe_width'].'"' : 'width="516"' ;//iframe width
			echo  ($settings['iframe_height']) ? 'height="'.$settings['iframe_height'].'"' : 'height="315"' ;//iframe height
			echo 'allow="';
			echo ($settings['autoplay']=='no') ? '': 'autoplay' ; //autoplay
			echo '"';
			echo '>';
			echo '</iframe>';
			}

			echo '</div>';

		}

}


