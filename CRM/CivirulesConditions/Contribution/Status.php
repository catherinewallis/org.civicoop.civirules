<?php

class CRM_CivirulesConditions_Contribution_Status extends CRM_Civirules_Condition {

  private $conditionParams = array();

  /**
   * Method to set the Rule Condition data
   *
   * @param array $ruleCondition
   * @access public
   */
  public function setRuleConditionData($ruleCondition) {
    parent::setRuleConditionData($ruleCondition);
    $this->conditionParams = array();
    if (!empty($this->ruleCondition['condition_params'])) {
      $this->conditionParams = unserialize($this->ruleCondition['condition_params']);
    }
  }

  public function isConditionValid(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $contribution = $triggerData->getEntityData('Contribution');
    if ($contribution['contribution_status_id'] == $this->conditionParams['contribution_status_id']) {
      return true;
    }
    return false;
  }

  /**
   * Returns a redirect url to extra data input from the user after adding a condition
   *
   * Return false if you do not need extra data input
   *
   * @param int $ruleConditionId
   * @return bool|string
   * @access public
   * @abstract
   */
  public function getExtraDataInputUrl($ruleConditionId) {
    return CRM_Utils_System::url('civicrm/civirule/form/condition/contributionstatus/', 'rule_condition_id='.$ruleConditionId);
  }

  /**
   * Returns a user friendly text explaining the condition params
   * e.g. 'Older than 65'
   *
   * @return string
   * @access public
   * @throws /\CiviCRM_API3_Exception
   */
  public function userFriendlyConditionParams() {
    $contributionStatus =  $status = civicrm_api3('OptionValue', 'getvalue', array(
      'return' => 'label',
      'option_group_id' => 'contribution_status',
      'value' => $this->conditionParams['contribution_status_id']));
    return 'Contribution status is '.$contributionStatus;
  }

  /**
   * Returns an array with required entity names
   *
   * @return array
   * @access public
   */
  public function requiredEntities() {
    return array('Contribution');
  }

}