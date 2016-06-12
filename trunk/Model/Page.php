<?php
App::uses('AppModel', 'Model');
/**
 * Page Model
 *
 * @property Category $Category
 */
class Page extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	public function getPages($id = false) {
		if (!$id) {
			return $this->find('all', array(
				'conditions' => array(
					'Page.published' => 1,
					'CURDATE() BETWEEN IF(Page.start_publish IS NOT NULL, Page.start_publish, CURDATE() - INTERVAL 1 DAY) AND IF(Page.end_publish IS NOT NULL, Page.end_publish, CURDATE() + INTERVAL 1 DAY)'
				), 
				'order' => 'Page.start_publish DESC')
			);
		} else {
			return $this->find('first', array(
				'conditions' => array(
					'Page.id' => $id,
					'Page.published' => 1,
					'CURDATE() BETWEEN IF(Page.start_publish IS NOT NULL, Page.start_publish, CURDATE() - INTERVAL 1 DAY) AND IF(Page.end_publish IS NOT NULL, Page.end_publish, CURDATE() + INTERVAL 1 DAY)'
				), 
				'order' => 'Page.start_publish DESC')
			);
		}
	}
	
	public function getHomePages() {
		return $this->find('all', array(
			'conditions' => array(
				'Page.front_page' => 1, 
				'Page.published' => 1,
				'CURDATE() BETWEEN IF(Page.start_publish IS NOT NULL, Page.start_publish, CURDATE() - INTERVAL 1 DAY) AND IF(Page.end_publish IS NOT NULL, Page.end_publish, CURDATE() + INTERVAL 1 DAY)'
			), 
			'order' => 'Page.start_publish DESC')
		);
	}
	
	public function getContactPage() {
		return $this->find('all', array(
			'conditions' => array(
				"LOWER(Page.title) LIKE '%contact%'", 
				'Page.published' => 1,
				'CURDATE() BETWEEN IF(Page.start_publish IS NOT NULL, Page.start_publish, CURDATE() - INTERVAL 1 DAY) AND IF(Page.end_publish IS NOT NULL, Page.end_publish, CURDATE() + INTERVAL 1 DAY)'
			), 
			'order' => 'Page.start_publish DESC')
		);
	}
	
	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $val) {
			if (isset($val[$this->alias]['start_publish']) && !empty($val[$this->alias]['start_publish'])) {
				$results[$key][$this->alias]['start_publish'] = date('d-m-Y', strtotime($val[$this->alias]['start_publish']));
			}
			if (isset($val[$this->alias]['end_publish']) && !empty($val[$this->alias]['end_publish'])) {
				$results[$key][$this->alias]['end_publish'] = date('d-m-Y', strtotime($val[$this->alias]['end_publish']));
			}
		}
		return $results;
	}
	
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['start_publish'])){
			if (empty($this->data[$this->alias]['start_publish'])) {
				$this->data[$this->alias]['start_publish'] = date('Y-m-d H:i:s');
			} else {
				$this->data[$this->alias]['start_publish'] = date('Y-m-d H:i:s', strtotime($this->data[$this->alias]['start_publish']));
			}
		}
		if (isset($this->data[$this->alias]['end_publish'])){
			if (!empty($this->data[$this->alias]['end_publish'])) {
				$this->data[$this->alias]['end_publish'] = date('Y-m-d H:i:s', strtotime($this->data[$this->alias]['end_publish']));
			}
		}
		if (isset($this->data[$this->alias]['tags']) && !empty($this->data[$this->alias]['tags'])){
			$tags = explode(',', $this->data[$this->alias]['tags']);
			App::uses('Tag', 'Model');
			$this->Tag = new Tag;
			foreach ($tags as $d) {
				$data['tag'] = $d;
				if (!$_tag = $this->Tag->find('first', array('conditions' => array('tag' => $data['tag'])))) {
					$this->Tag->create();
					$this->Tag->save($data);
				} else {
					if (!isset($this->data[$this->alias]['id'])) {
						$_tag['Tag']['count'] = $_tag['Tag']['count'] + 1;
						$this->Tag->save($_tag);
					}
				}
			}
		}
		return true;
	}

}
