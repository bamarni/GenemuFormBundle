# Use JQueryAutocomplete to Propel Ajax values

## Usage:

``` php
<?php
// ...
public function buildForm(FormBuilder $builder, array $options)
{
    $builder
        ->add('member', 'genemu_jqueryautocompleter', array(
            'route_name' => 'ajax_member',
            'class' => 'Genemu\Bundle\ModelBundle\Model\Member',
            'widget' => 'model'
        ))
        ->add('cities', 'genemu_jqueryautocompleter', array(
            'route_name' => 'ajax_city',
            'class' => 'Genemu\Bundle\ModelBundle\Model\City',
            'widget' => 'model',
            'multiple' => true
        ));
}
```

## Add functions to Controller:

``` php
<?php
namespace MyNamespace;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Genemu\Bundle\ModelBundle\Model\MemberQuery;
use Genemu\Bundle\ModelBundle\Model\CityQuery;

class MyClassAjaxController extends Controller
{
    /**
     * @Route("/ajax_member", name="ajax_member")
     */
    public function ajaxMemberAction(Request $request)
    {
        $value = $request->get('term');

        $members = MemberQuery::create()->findByName($value.'%');

        $json = array();
        foreach ($members as $member) {
            $json[] = array(
                'label' => $member->getName(),
                'value' => $member->getId()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }

    /**
     * @Route("/ajax_city", name="ajax_city")
     */
    public function ajaxCityAction(Request $request)
    {
        $value = $request->get('term');

        $cities = CityQuery::create()->findByName($value.'%');

        $json = array();
        foreach ($cities as $city) {
            $json[] = array(
                'label' => $member->getName(),
                'value' => $member->getId()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
}
```