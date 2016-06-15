<?php

namespace Liaiyong\Subscriber\Api;

use Lay\Advance\Core\Action;
use Lay\Advance\Core\Configuration;
use Lay\Advance\Core\Error;
use Lay\Advance\Core\Errode;
use Lay\Advance\Util\Logger;

use Liaiyong\Subscriber\Api\Data\VResponse;

use Exception;

abstract class ApiAction extends Action {
    /**
     * @var VResponse
     */
    protected $vresponse;
    public function onCreate() {
        parent::onCreate();
        //
        $this->vresponse = new VResponse();
    }
    public function lifecycle() {
        try {
            parent::lifecycle();
        } catch(Error $e) {
            $this->failure(Errode::__lastErrode());
            // just redo render
            $this->onRender();
            // no fire render event
        } catch(Exception $e) {
            throw $e;
        }
    }
    // overide
    public function onRender() {
        // render
        header('X-Powered-By: dcux');
        $rep = $this->request->getExtension();
        switch ($rep) {
            case 'xml' :
                $this->template->xml();
                break;
            case 'csv' :
                $this->template->csv();
                break;
            case '' :
            case 'json' :
            default:
                $this->template->json();
                break;
        }
    }

    protected function failure($code, $msg = null) {
        $this->vresponse = empty($this->vresponse) ? new VResponse() : $this->vresponse;
        $this->vresponse->rsp = 0;
        $this->vresponse->api = $this->getApiname();
        $this->vresponse->data = $msg;
        $this->vresponse->code = $code;
    }
    protected function success($data) {
        $this->vresponse = empty($this->vresponse) ? new VResponse() : $this->vresponse;
        $this->vresponse->rsp = 1;
        $this->vresponse->api = $this->getApiname();
        $this->vresponse->code = 0;
        $this->vresponse->data = $data;
    }
}