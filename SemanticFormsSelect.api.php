<?php
class ApiSemanticFormsSelect extends ApiBase {

	public function execute() {

		$params = $this->extractRequestParams();

		if ( $params['approach'] == 'smw' ) {
			$json = SemanticFormsSelect::QueryExecution( $params['query'], $params['sep'] );
		} else {
			$json = SemanticFormsSelect::FunctionExecution( $params['query'], $params['sep'] );
		}

		$output = json_decode( $json );
		
		$result = $this->getResult();
		$result->setIndexedTagName( $output->values, 'value' );
		$result->addValue( $this->getModuleName(), 'values', $output->values );
		$result->addValue( $this->getModuleName(), 'count', $output->count );

		return true;

	}

	public function getAllowedParams() {
		return array(
			'approach' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'query' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'sep' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			)
		);
	}

	public function getDescription() {
		return array(
			'API for providing SemanticFormsSelect values'
		);
	}
	public function getParamDescription() {
		return array(
			'approach' => 'The actual approach: function or smw',
			'query' => 'The query of the former'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': 1.1';
	}

}