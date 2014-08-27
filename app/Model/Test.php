<?php
class Test extends AppModel {
	public $belongsTo = array(
		'Study' => array(),
		'ReviewedBy' => array(
			'className' => 'Test',
			'foreignKey' => 'reviewed_id',
		),
	);
	public $hasMany = array(
		'ReviewOf' => array(
			'className' => 'Test',
			'foreignKey' => 'reviewed_id',
		),
	);

	public $virtualFields = array(
		'user_name' => '(select users.username from users where users.id = (select codedpapers.user_id from codedpapers WHERE codedpapers.id = (select codedpaper_id from studies where studies.id = study_id)))',
	);

	public $validate = array(

		'hypothesized' => array(
	        'rule' => 'notEmpty',
			'required' => true,
            'allowEmpty' => true,
	    ),
		'prior_hypothesis' => array(
			'rule' => 'notEmpty',
			'required' => true,
	        'allowEmpty' => true,
	    ),
		'analytic_design_code' => array(
			'rule' => 'notEmpty',
	        'required' => true,
	        'allowEmpty' => true
	    ),
		'methodology_codes' => array(
			'rule' => 'notEmpty',
	        'required' => false,
	        'allowEmpty' => true
	    ),
		'independent_variables' => array(
	       	'rule' => 'notEmpty',
			'required' => true	,
            'allowEmpty' => true
	   ),
		'dependent_variables' => array(
			'rule' => 'notEmpty',
			'required' => true,
            'allowEmpty' => true
		),
		'other_variables' => array(
			'rule' => 'notEmpty',
			'required' => true,
            'allowEmpty' => true
		),
		'N_total' => array(
	       'rule'    => array("naturalNumber",true),
           'required' => true,
           'allowEmpty' => true,
	       'message' => 'N total must be a natural number'
	    ),
		'data_points_excluded' => array(
	       'rule'    => array("naturalNumber",true),
           'required' => true,
           'allowEmpty' => true,
	       'message' => 'Data points excluded must be a natural number.'
	    ),
		'reasons_for_exclusions' => array(
			'rule' => 'notEmpty',
			'required' => false,
            'allowEmpty' => true
		),
		'type_of_statistical_test_used' => array(
			'rule' => 'notEmpty',
			'required' => true,
            'allowEmpty' => true
		),
        'N_used_in_analysis' => array(
            'rule' => 'notEmpty',
			'rule'    => "naturalNumber",
            'required' => true,
            'allowEmpty' => true,
            'message' => 'N used in analysis must be a natural number.'
        ),
		'inferential_test_statistic' => array(
	        'rule' => 'notEmpty',
			'required' => true,
            'allowEmpty' => true,
		),
		'inferential_test_statistic_value' => array(
		    'decimal' => array(
		        'rule'     => array('decimal',NULL,"/^\d+(\.\d+)?$/"),
		        'required' => true,
	            'allowEmpty' => true,
		        'message'  => 'Inferential test statistic: Numbers only, decimals marked by dot.',
		    )
		),
	    'degrees_of_freedom' => array(
	         'rule' => 'notEmpty',
			  'required' => true,
	          'allowEmpty' => true,
	    ),
        'reported_significance_of_test' => array(
	         'rule' => 'notEmpty',
			  'required' => true,
	          'allowEmpty' => true,
	     ),
	    'computed_significance_of_test' => array(
		    'decimal' => array(
		        'rule'    => array('range', 0, 1.0000000000001),
		        'required' => true,
	            'allowEmpty' => true,
		        'message'  => 'Computed significance: Must be a number between 0 and 1',
		    )
	    ),
	    'hypothesis_supported' => array(
	        'rule' => 'notEmpty',
			'required' => true,
            'allowEmpty' => true,
	    ),
		'reported_effect_size_statistic' => array(
	        'rule' => 'notEmpty',
			'required' => true,
            'allowEmpty' => true,
	    ),
		'reported_effect_size_statistic_value' => array(
		    'decimal' => array(
		        'rule'     => 'decimal', #array('decimal',NULL,"/^\d+(\.\d+)?$/"),
		        'required' => true,
	            'allowEmpty' => true,
		        'message'  => 'Reported effect size: Numbers only, decimals marked by dot.',
		    )
	    ),
    );
	public function createDummy ($study, $sstart, $tstart = 0) {
		$this->create();
		$data = array(
			'Test' => array('study_id' => $study['id'])
		);
		if($dummyentry = $this->save($data,$validate=FALSE)) {
			$ret = array('Study' =>
				array(
					$sstart => $study
				)
			);
			$ret['Study'][$sstart]['Test'] = array($tstart => $dummyentry['Test']);
			return $ret;
		}
		else { debug($this->validationErrors); die(); }
	}
}

