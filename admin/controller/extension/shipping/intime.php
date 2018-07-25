<?php
class ControllerExtensionShippingIntime extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/intime');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');



		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js");
		$this->document->addStyle("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css");



		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('intime', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/shipping/intime', 'token=' . $this->session->data['token'] . '&type=shipping', true));
		}




		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['entry_sender_obl'] = $this->language->get('entry_sender_obl');
		$data['entry_sender_BRANCH'] = $this->language->get('entry_sender_BRANCH');
		$data['entry_sender_LOCALITY'] = $this->language->get('entry_sender_LOCALITY');

		
		

		$data['entry_api_key'] = $this->language->get('entry_api_key');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping/intime', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/intime', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

		if (isset($this->request->post['intime_api_key'])) {
			$data['intime_api_key'] = $this->request->post['intime_api_key'];
		} else {
			$data['intime_api_key'] = $this->config->get('intime_api_key');
		}


		if (isset($this->request->post['intime_payment_type_id'])) {
			$data['intime_payment_type_id'] = $this->request->post['intime_payment_type_id'];
		} else {
			$data['intime_payment_type_id'] = $this->config->get('intime_payment_type_id');
		}




		if (isset($this->request->post['intime_area'])) {
			$data['intime_area'] = $this->request->post['intime_area'];
		} else {
			$data['intime_area'] = $this->config->get('intime_area');
		}






		if (isset($this->request->post['intime_order_area'])) {
			$data['intime_order_area'] = $this->request->post['intime_order_area'];
		} else {
			$data['intime_order_area'] = $this->config->get('intime_order_area');
		}

		if (isset($this->request->post['intime_order_city'])) {
			$data['intime_order_city'] = $this->request->post['intime_order_area'];
		} else {
			$data['intime_order_city'] = $this->config->get('intime_order_city');
		}

		if (isset($this->request->post['intime_order_branch'])) {
			$data['intime_order_branch'] = $this->request->post['intime_order_branch'];
		} else {
			$data['intime_order_branch'] = $this->config->get('intime_order_branch');
		}





		// если выбрана область то запрашиваем города с этой областью  GET_LOCALITY_FILTERED
		if($this->config->get('intime_area')){
		$data['LOCALITY'] = $this->send(['country_id'=>'215','area_id'=>$this->config->get('intime_area')],'GET_LOCALITY_FILTERED')->Entry_get_locality_filtered;
		}
		if (isset($this->request->post['intime_LOCALITY'])) {
			$data['intime_LOCALITY'] = $this->request->post['intime_LOCALITY'];
		} else {
			$data['intime_LOCALITY'] = $this->config->get('intime_LOCALITY');
		}
		// Получить список отделений 
		if($this->config->get('intime_LOCALITY')){
			$data['BRANCH'] = $this->send(['country_id'=>'215','area_id'=>$this->config->get('intime_area'),'locality_id'=>$this->config->get('intime_LOCALITY')],'GET_BRANCH_FILTERED')->Entry_get_branch_filtered;
		}
		if (isset($this->request->post['intime_BRANCH'])) {
			$data['intime_BRANCH'] = $this->request->post['intime_BRANCH'];
		} else {
			$data['intime_BRANCH'] = $this->config->get('intime_BRANCH');
		}
		if (isset($this->request->post['intime_status'])) {
			$data['intime_status'] = $this->request->post['intime_status'];
		} else {
			$data['intime_status'] = $this->config->get('intime_status');
		}

		if (isset($this->request->post['intime_cancel_packaging'])) {
			$data['intime_cancel_packaging'] = $this->request->post['intime_cancel_packaging'];
		} else {
			$data['intime_cancel_packaging'] = $this->config->get('intime_cancel_packaging');
		}

		if (isset($this->request->post['intime_payer_type_id'])) {
			$data['intime_payer_type_id'] = $this->request->post['intime_payer_type_id'];
		} else {
			$data['intime_payer_type_id'] = $this->config->get('intime_payer_type_id');
		}


		
		if (isset($this->request->post['intime_ched'])) {
			$data['intime_ched'] = $this->request->post['intime_ched'];
		} else {
			$data['intime_ched'] = $this->config->get('intime_ched');
		}

		if (isset($this->request->post['intime_payer_type_ched'])) {
			$data['intime_payer_type_ched'] = $this->request->post['intime_payer_type_ched'];
		} else {
			$data['intime_payer_type_ched'] = $this->config->get('intime_payer_type_ched');
		}

		

		


		if (isset($this->request->post['intime_goods'])) {
			$data['intime_goods'] = $this->request->post['intime_goods'];
		} else {
			$data['intime_goods'] = $this->config->get('intime_goods');
		}


		if (isset($this->request->post['intime_goods'])) {
			$data['intime_return_day'] = $this->request->post['intime_return_day'];
		} else {
			$data['intime_return_day'] = $this->config->get('intime_return_day');
		}


		if (isset($this->request->post['flat_sort_order'])) {
			$data['intime_sort_order'] = $this->request->post['intime_sort_order'];
		} else {
			$data['intime_sort_order'] = $this->config->get('intime_sort_order');
		}
		//получаем областя по украине 
		$data['AREA'] = $this->send(['country_id'=>215],'GET_AREA_FILTERED')->Entry_get_area_filtered;

		$data['GOODS'] = $this->send([],'GET_GOODS_DESC_BY_ID')->Entry_get_goods_desc_by_id;



		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/shipping/intime', $data));
	}
	public function orderadd(){

		$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], true);
				$this->load->language('extension/shipping/intime');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$order_id = $this->request->get['order_id'];
		$this->load->language('extension/shipping/intime');
		$this->load->model('sale/order');
		$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

		$this->document->addScript("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js");
		$this->document->addStyle("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css");

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['action'] = $this->url->link('extension/shipping/intime/ordersave', 'token=' . $this->session->data['token'], true);

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		// города
		$sender_loc = $this->send(['id'=>$this->config->get('intime_LOCALITY')],'GET_LOCALITY_BY_ID')->Entry_get_locality_by_id;
		$sender_loc_a["{$sender_loc->id}"] = $sender_loc->name_ru;


		// Склад отправителя
		$sender_branch = $this->send(['id'=>$this->config->get('intime_BRANCH')],'GET_BRANCH_BY_ID')->Entry_get_branch_by_id;
		$sender_branch_a["{$sender_branch->id}"] = $sender_branch->name_ru."(".$sender_branch->address_ru.")";

		//облстя отпрвитель
		$AREA = $this->send(['country_id'=>215],'GET_AREA_FILTERED')->Entry_get_area_filtered;
		$receiver_area = [];
		$receiver_area['---'] = "--- Выберите область ---";
		foreach ($AREA as $key => $value) {
			$receiver_area["{$value->id}"] = $value->area_name_ru;
		}

		 $GET_GOODS_DESC_BY_ID = $this->send([],'GET_GOODS_DESC_BY_ID')->Entry_get_goods_desc_by_id;


		 foreach ($GET_GOODS_DESC_BY_ID as $key => $value) {
			$sender_GOODS["{$value->id}"] = $value->sname;
		}

		$data['types'] =  [
		    'Отправитель'=>[
		    	'locality_id'=>['title'=>'Город отправления','value'=>$sender_loc_a],
		    	'sender_warehouse_id'=>['title'=>'Склад/поштомат','value'=>$sender_branch_a],
		    	'sender_address'=>['title'=>'Адрес забора','value'=>'']
		    ],
		    	  
		    'Получатель'=>[
		    	'receiver_lastname'=>['title'=>'Фамилия','value'=>$order_info['lastname'],'type'=>'input'],
		    	'receiver_firstname'=>['title'=>'Имя','value'=> explode(" ",$order_info['firstname'])[0]],
		    	'receiver_patronymic'=>['title'=>'Отчество','value'=>@explode(" ",$order_info['firstname'])[1]],
		    	'receiver_obl'=>['title'=>'Область','value'=>$receiver_area],
		    	'receiver_locality_id'=>['title'=>'Город','value'=>[]],
		    	'receiver_warehouse_id'=>['title'=>'Отделение</br><b style="font-size: 9px;">('.$order_info['shipping_address_1'].")</b>",'value'=>[]],
		    	'receiver_cellphone'=>['title'=>'Телефон','value'=>$order_info['telephone']]

		    ],

		    'Дополнительная информация'=>[
		    			    	'payer_type_id'=>['title'=>'Плательшик','value'=>[
		    			    		'2'=>'Одержувач',
		    			    		'1'=>'Відправник',
		    			    		'3'=>'Третя особа',
		    			    		'4'=>'50 на 50',
		    			    		'5'=>'Довільно'
		    			    	],'selected_id'=>$this->config->get('intime_payer_type_id')],
		    			    	'return_day'=>['title'=>'Автовозврат<br>(Дней)','value'=>$this->config->get('intime_return_day') ,'type'=>'input','group'=>'Дней.'],


		    			    	'cost_return'=>['title'=>'Объявленаяя стоимость','value'=>round($this->currency->format($this->tax->calculate($order_info['total'], 0, $this->config->get('config_tax')), $this->session->data['currency']),0),'group'=>'грн.'],

		    			    	'cancel_packaging'=>['title'=>'Отказ от упаковки','value'=>[
		    			    		'0'=>'Да',
		    			    		'1'=>'Нет'
		    			    	],'selected_id'=>$this->config->get('intime_cancel_packaging')],


		    			    	'payment_type_id'=>['title'=>'Тип оплаты','value'=>[
		    			    		'1'=>'Наличный',
		    			    		'2'=>'Безналичный',
		    			    	
		    			    	],'selected_id'=>$this->config->get('intime_payment_type_id')],


		    			    	'client_doc_id'=>['title'=>'Номер заказа','value'=>$order_info['order_id'],'type'=>'input'],
		    ],
		    'Вес/место'=>[

		    	'seats[Goods_type_id]'=>['title'=>'Тип','value'=>[

		    		'1'=>'Посилки та вантажі',
		    		'2'=>'Шини/Диски',
		    		'3'=>'Палети',
		    		'4'=>'Документи',

		    	]],
		    	'seats[Goods_type_descr_id]'=>['title'=>'Тип','value'=>$sender_GOODS,'selected_id'=>$this->config->get('intime_goods')],
		    	'seats[Weight_m]'=>['title'=>'Вага, кг','value'=>'1','type'=>'input','group'=>'кг.'],
		    	'seats[Count_m]'=>['title'=>'Кількість місць ','value'=>1,'type'=>'input','group'=>'шт.'],
		    	'seats[Length_m]'=>['title'=>'Довжина, см','value'=>10,'type'=>'input'],
		    	'seats[Width_m]'=>['title'=>'Ширина, см','value'=>10,'type'=>'input'],
		    	'seats[Height_m]'=>['title'=>'Висота, см','value'=>10,'type'=>'input'],
		    ],
		     'Наложка'=>[
		    	'ched'=>['title'=>'Наложка','value'=>['1'=>'Да','2'=>'Нет'],'selected_id'=>$this->config->get('intime_ched')],
		    	'pay_s_paced'=>['title'=>'Плательшик','value'=>['1'=>'Відправник сек’юрпакета(получатель груза)','2'=>'Одержувач сек’юрпакета(Отправитель груза)'],'selected_id'=>$this->config->get('intime_payer_type_ched')],
		    	'cash_on_delivery_sum'=>['title'=>'Денежный перевод','value'=>round($this->currency->format($this->tax->calculate($order_info['total'], 0, $this->config->get('config_tax')), $this->session->data['currency']),0),'group'=>'грн.'],
		    ],
	
		];



		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
	    $data['heading_title'] = $this->language->get('heading_title');


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => "Интайм ТТН",
			'href' => $this->url->link('sale/intime', 'token=' . $this->session->data['token'], 'SSL')
		);
			$this->response->setOutput($this->load->view('extension/shipping/intime_add_order', $data));
	}
	public function print_ttn(){
                        libxml_use_internal_errors(true);
						$string ="";
						$head = "";
						foreach ($_GET['selected'] as $key => $value) {
							$dom = new DOMDocument;
							$dom->loadHTML(file_get_contents("http://ora01.intime.ua:8080/PrintStikers/?apikey=".$this->config->get('intime_api_key')."&ttn=".$value));
							$xpath = new DOMXPath($dom);
							$tags = $xpath->query('//body');
							foreach ($tags as $tag) {
								$string .= $dom->saveHTML($tag);
							}
						}
		echo $string;
		echo "<style>@media print {section{float:left; margin-left:20px,margin-bottom:20px;    position: relative;margin-left: 30px;margin-bottom: 65px;}}</style>";
	}
	public function ordersave(){

		$data = $_POST;
		$seats = $data['seats'];
	

		unset($data['seats']);

		$data['cash_on_delivery_sum'] = floor($data['cash_on_delivery_sum']);

		$data['seats'] = '<SEATS>
				<SEAT>
				<GOODS_TYPE_ID>'.$seats['Goods_type_id'].'</GOODS_TYPE_ID>
				<WEIGHT_M>'.$seats['Weight_m'].'</WEIGHT_M>
				<LENGTH_M>'.$seats['Length_m'].'</LENGTH_M>
				<WIDTH_M>'.$seats['Width_m'].'</WIDTH_M>
				<HEIGHT_M>'.$seats['Height_m'].'</HEIGHT_M>
				<COUNT_M>'.$seats['Count_m'].'</COUNT_M>
				<GOODS_TYPE_DESCR_ID>'.$seats['Goods_type_descr_id'].'</GOODS_TYPE_DESCR_ID>
				<BOX_ID></BOX_ID>
				</SEAT>
		</SEATS>';

		    $this->db->query("UPDATE oc_order SET forwarded_ip={$data['cash_on_delivery_sum']} WHERE order_id='{$data['client_doc_id']}'");


		$argv['declaration_insert_update']['api_key']                  = $this->config->get('intime_api_key');
		$argv['declaration_insert_update']['locality_id']              = $data['locality_id'];
        $argv['declaration_insert_update']['sender_warehouse_id']      = $data['sender_warehouse_id'];
        $argv['declaration_insert_update']['sender_address']           = strlen(@$data['sender_address']) > 0 ? $data['sender_address'] : '';
        $argv['declaration_insert_update']['receiver_okpo']            = strlen(@$data['receiver_okpo']) ? $data['receiver_okpo'] : '';
        $argv['declaration_insert_update']['receiver_company_name']    = strlen(@$data['receiver_company_name']) ? $data['receiver_company_name'] : '';
        $argv['declaration_insert_update']['receiver_cellphone']       = $data['receiver_cellphone'];
        $argv['declaration_insert_update']['receiver_lastname']        = $data['receiver_lastname'];
        $argv['declaration_insert_update']['receiver_firstname']       = $data['receiver_firstname'];
        $argv['declaration_insert_update']['receiver_patronymic']      = $data['receiver_patronymic'];
        $argv['declaration_insert_update']['receiver_locality_id']     = $data['receiver_locality_id'];
        $argv['declaration_insert_update']['receiver_warehouse_id']    = $data['receiver_warehouse_id'];
        $argv['declaration_insert_update']['receiver_address']         = strlen(@$data['receiver_address']) > 0 ? $data['receiver_address'] : '';
        $argv['declaration_insert_update']['payment_type_id']          = $data['payment_type_id'];
        $argv['declaration_insert_update']['payer_type_id']            = $data['payer_type_id'];
        $argv['declaration_insert_update']['return_day']               = strlen(@$data['return_day']) ? $data['return_day'] : '';
        $argv['declaration_insert_update']['cost_return']              = $data['cost_return'];
        $argv['declaration_insert_update']['cash_on_delivery_sum']     = @$data['cash_on_delivery_sum'];
        $argv['declaration_insert_update']['client_doc_id']            = $data['client_doc_id'];
        $argv['declaration_insert_update']['cancel_packing']           = @$data['cancel_packing'];
        $argv['declaration_insert_update']['sender_paid_sum']          = strlen(@$data['sender_paid_sum']) > 0 ? $data['sender_paid_sum'] : '';
        $argv['declaration_insert_update']['third_party_okpo']         = strlen(@$data['third_party_okpo']) > 0 ? $data['third_party_okpo'] : '';
        $argv['declaration_insert_update']['third_party_company_name'] = strlen(@$data['third_party_company_name']) > 0 ? $data['third_party_company_name'] : '';
        $argv['declaration_insert_update']['third_party_cellphone']    = strlen(@$data['third_party_cellphone']) > 0 ? $data['third_party_cellphone'] : '';
        $argv['declaration_insert_update']['third_party_lastname']     = strlen(@$data['third_party_lastname']) > 0 ? $data['third_party_lastname'] : '';
        $argv['declaration_insert_update']['third_party_firstname']    = strlen(@$data['third_party_firstname']) > 0 ? $data['third_party_firstname'] : '';
        $argv['declaration_insert_update']['third_party_patronymic']   = strlen(@$data['third_party_patronymic']) > 0 ? $data['third_party_patronymic'] : '';
        $argv['declaration_insert_update']['third_patry_store_id']     = strlen(@$data['third_patry_store_id']) > 0 ? $data['third_patry_store_id'] : '';
        $argv['declaration_insert_update']['third_party_address']      = strlen(@$data['third_party_address']) > 0 ? $data['third_party_address'] : '';
        $argv['declaration_insert_update']['packages']                 = strlen(@$data['packages']) > 0 ? $data['packages'] : '';

        if($data['cash_on_delivery_sum'] > 0){
        	      $argv['declaration_insert_update']['commands']                 = '<COMS><COM><COM_ID>50</COM_ID><COM_VAL>'.$data['cash_on_delivery_sum'].'</COM_VAL><PAYER_ID>2</PAYER_ID><PAYMENT_ID>1</PAYMENT_ID></COM></COMS>';
        }
  
        $argv['declaration_insert_update']['containers']               = strlen(@$data['containers']) > 0 ? $data['containers'] : '';
        $argv['declaration_insert_update']['seats']                    = strlen(@$data['seats']) > 0 ? $data['seats'] : '';
        $argv['declaration_insert_update']['services'] = "";

		$client = new SoapClient("http://esb.intime.ua:8080/services/intime_api_3.0?wsdl");
    	$response = $client->__soapCall('DECLARATION_INSERT_UPDATE', $argv);

		$response = $this->toArray($response);

		$response['header'] = $this->load->controller('common/header');
		$response['column_left'] = $this->load->controller('common/column_left');
		$response['footer'] = $this->load->controller('common/footer');
		$response['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$response['breadcrumbs'][] = array(
			'text' => "Интайм ТТН",
			'href' => $this->url->link('sale/intime', 'token=' . $this->session->data['token'], 'SSL')
		);


		if($response['Entry_declaration_ins_upd']['res']=="OK"){


					$this->db->query("UPDATE oc_order SET intime_ttn='{$response['Entry_declaration_ins_upd']['decl_id']}' WHERE order_id = '{$argv['declaration_insert_update']['client_doc_id']}'");


			$this->response->setOutput($this->load->view('extension/shipping/intime_return_s.tpl', $response));

		}else{
			$this->response->setOutput($this->load->view('extension/shipping/intime_return_error.tpl', $response));
		}
	}
	public function ttn(){


		


		$data = [];
		$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], true);
		$data['button_save'] = "Печать";
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
	    $data['heading_title'] = $this->language->get('heading_title');


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => "Заказы",
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL')
		);

		$rus = $this->db->query("SELECT intime_ttn FROM oc_order WHERE intime_ttn!='' order by intime_ttn DESC")->rows;
		$ttn = [];
			foreach ($rus as $key => $value) {
				$ttn[] = $value['intime_ttn'];
			}
		$response = $this->toArray($this->send(['decl_num'=>implode(",", $ttn)],'INFO_TN'));
		$data22 = [];
		if(isset($response['entry_info_tn'][0])){
					foreach ($response['entry_info_tn'] as $key => $value) {
			$data22[] = [
				'№'=>$value['decl_num']."</br>(".$value['decl_num_1c'].")",
				'Заказ'=>"<a target='_blank' href='".$this->url->link('sale/order/edit', 'order_id='.$value['dop_nomer'].'&token=' . $this->session->data['token'], 'SSL')."'>".$value['dop_nomer']."</a>",
				'Клиент'=>$value['client_receiver']."<br>".$value['warehouse_receiver']."<br>".$value['address_receiver'],
				'Дата создания'=> date("d-m-Y",strtotime(explode("T",$value['date_creation'])[0])),
				'Дата доставки'=> date("d-m-Y",strtotime(explode("T",$value['date_delivery'])[0])),
				'Наложка'=>$value['cod']." грн.",
				'Места'=>$value['seats_num'],
				'Статус'=>$value['status'],
				'Стоимость доставки'=>$value['amount_all']." грн",
				'Вес'=>$value['weight']
			];
			
		}



		}else{



			$data22[] = [
				'№'=>$response['entry_info_tn']['decl_num']."</br>(".$response['entry_info_tn']['decl_num_1c'].")",
				'Заказ'=>"<a target='_blank' href='".$this->url->link('sale/order/edit', 'order_id='.$response['entry_info_tn']['dop_nomer'].'&token=' . $this->session->data['token'], 'SSL')."'>".$response['entry_info_tn']['dop_nomer']."</a>",
				'Клиент'=>$response['entry_info_tn']['client_receiver']."<br>".$response['entry_info_tn']['warehouse_receiver']."<br>".$response['entry_info_tn']['address_receiver'],
				'Дата создания'=> date("d-m-Y",strtotime(explode("T",$response['entry_info_tn']['date_creation'])[0])),
				'Дата доставки'=> date("d-m-Y",strtotime(explode("T",$response['entry_info_tn']['date_delivery'])[0])),
				'Наложка'=>$response['entry_info_tn']['cost_return']." грн.",
				'Места'=>$response['entry_info_tn']['seats_num'],
				'Статус'=>$response['entry_info_tn']['status'],
				'Стоимость доставки'=>$response['entry_info_tn']['amount_all']." грн",
				'Вес'=>$response['entry_info_tn']['weight']
			];




		}
		$data['info'] = $data22;
	






		$this->response->setOutput($this->load->view('extension/shipping/intime_ttn', $data));
	}
	public function area(){
		$data = $this->send(['country_id'=>'215','area_id'=>$_GET['area']],'GET_LOCALITY_FILTERED');


		if(isset($data->Entry_get_locality_filtered)){
			echo json_encode($data->Entry_get_locality_filtered);
		}else{
			echo json_encode([]);

		}
	}
	public function branch(){
		$data = $this->send(['country_id'=>'215','area_id'=>$_GET['intime_area'],'locality_id'=>$_GET['intime_LOCALITY']],'GET_BRANCH_FILTERED');

		if(isset($data->Entry_get_branch_filtered)){
			echo json_encode($data->Entry_get_branch_filtered);
		}else{
			echo json_encode([]);

		}
	}
		protected function send($data,$type){
	    $data['api_key'] = $this->config->get('intime_api_key');
		$result = $this->cache->get($type.md5(implode(",", $data)));
		if($result){
			$result = json_decode(json_encode($result),false);
			return $result;
		}else{
		$client = new SoapClient("http://esb.intime.ua:8080/services/intime_api_3.0?wsdl");
		$result = $client->__soapCall($type,[$type=>$data]);
		$this->cache->set($type.md5(implode("", $data)),$result);
		return $result;
		}


	}
	protected function toArray($var) {
		is_object($var) AND $var = (array) $var;
		if (is_array($var)) {
			foreach ($var as $key => $value) {
				is_object($value) AND $value = (array) $value;
				$var[$key] = $this->toArray($value);
			}
		}
		return $var;
	}
	protected function validate() {
	


		return !$this->error;
	}
}