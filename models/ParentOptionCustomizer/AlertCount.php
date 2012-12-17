<?php
class KlearMatrix_Model_ParentOptionCustomizer_AlertCount implements KlearMatrix_Model_Interfaces_ParentOptionCustomizer
{
    /**
     * @var KlearMatrix_Model_RouteDispatcher
     */
    protected $_mainRouter = null;

    /**
     * @var array
     */
    protected $_mainRouterOriginalParams = null;

    /**
     * @var KlearMatrix_Controller_Helper_CreateListWhere
     */
    protected $_createListWhere = null;

    /**
     * @var KlearMatrix_Model_AbstractOption
     */
    protected $_option = null;

    /**
     * @var string sql condition
     */
    protected $_sqlCondition;

    protected $_resultWrapper = 'span';
    protected $_cssClass = 'alertCount';

    /**
     * @param string $sqlCondition
     */
    public function __construct($sqlCondition)
    {
        if (!$sqlCondition) {

            Throw new Exception("AlertCount requires a SQL condition");
        }

        $this->_sqlCondition = $sqlCondition;
        $this->_createListWhere = new KlearMatrix_Controller_Helper_CreateListWhere;

        $front = Zend_Controller_Front::getInstance();
        $this->_mainRouter = $front->getRequest()->getUserParam("mainRouter");
        $this->_mainRouterOriginalParams = $this->_mainRouter ->getParams();
    }

    public function setOption (KlearMatrix_Model_AbstractOption $option)
    {
        $this->_option = $option;
    }

    /**
     * @return KlearMatrix_Model_ParentOptionCustomizer_Response
     */
    public function customize($parentModel)
    {
        $item = $this->_mainRouter->loadScreen($this->_option->getName());
        $model = $item->getObjectInstance();
        $mapper = $model->getMapper();

        //Al tratarse de un filtered screen necesita la pk del padre
        $this->_mainRouter->setParams(array("pk" => $parentModel->getPrimaryKey()));

        $where = $this->_createListWhere->createListWhere(new KlearMatrix_Model_ColumnCollection(),
                                                          $model,
                                                          new KlearMatrix_Model_MatrixResponse(),
                                                          $item);

        if (is_array($where)) {

            $where[0] = "(" . $where[0] . ") and " . $this->_sqlCondition;

        } else {

            $where = "($where) and " . $this->_sqlCondition;
        }

        $alertNum = $mapper->countByQuery($where);
        if ($alertNum == 0) {

            return null;
        }

        $this->_mainRouter->setParams($this->_mainRouterOriginalParams);

        $response = new KlearMatrix_Model_ParentOptionCustomizer_Response();
        $response->setResult($alertNum)
                 ->setWrapper($this->_resultWrapper)
                 ->setCssClass($this->_cssClass);

        return $response;
    }
}