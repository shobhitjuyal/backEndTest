<?php

namespace Drupal\custom_module\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides route responses for the node detail.
 */
class CustomNodeDetail extends ControllerBase {

  /**
   * Function to return content.
   */
  public function content(Request $request) {
    $api = $request->attributes->get('api');
    $nid = $request->attributes->get('nid');
    $type = "";
    if ($nid && is_numeric($nid)) {
      $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
      $type = $node ? $node->bundle() : $type;
    }
    if ($api && $type == "page" && $api == \Drupal::config('system.site')->get('siteapikey')) {
      return new JsonResponse(["content" => "You are welcome!"]);
    }
    else {
      throw new AccessDeniedHttpException();
    }
  }

}
