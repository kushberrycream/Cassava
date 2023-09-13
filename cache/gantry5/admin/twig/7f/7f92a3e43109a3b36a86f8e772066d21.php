<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* forms/fields/unknown/unknown.html.twig */
class __TwigTemplate_d52bd6cc008ae79ec57e82c15400d943 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        if (twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "fields", [], "any", false, false, false, 1)) {
            // line 2
            echo "    ";
            $this->loadTemplate("forms/fields/array/list.list.twig", "forms/fields/unknown/unknown.html.twig", 2)->display($context);
        } else {
            // line 4
            echo "    ";
            $this->loadTemplate("forms/fields/input/text.html.twig", "forms/fields/unknown/unknown.html.twig", 4)->display($context);
        }
    }

    public function getTemplateName()
    {
        return "forms/fields/unknown/unknown.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 4,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "forms/fields/unknown/unknown.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\administrator\\components\\com_gantry5\\templates\\forms\\fields\\unknown\\unknown.html.twig");
    }
}
