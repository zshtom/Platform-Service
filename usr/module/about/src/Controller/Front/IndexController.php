<?php
namespace Module\about\Controller\Front;


use Pi\Mvc\Controller\ActionController;


class IndexController extends ActionController
{
    public function indexAction()
    {

        $this->view()->setTemplate('about-index');

        $this->view()->assign('content','时趣SCRM是国内领先的、大数据驱动的微信社会化关系管理平台，主要服务对象为品牌客户和大中型企业客户。通过时趣微信SCRM的多维度标签系以及活跃度、忠诚度等社会化属性分析，让您360°掌握粉丝信息。同时，结合时趣强大的数据洞察和预测技术，企业可以以
                     数据为导向，制定品牌营销策略，开展精准互动营销，并对营销结果进行监控和衡量，从而全面提升企业社会化营销水平。');

    }
}







