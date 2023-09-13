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

/* partials/error_head.html.twig */
class __TwigTemplate_bff1b8528356712063f0eb96579bfda2 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'head_application' => [$this, 'block_head_application'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "partials/page_head.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("partials/page_head.html.twig", "partials/error_head.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head_application($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "<meta charset=\"utf-8\" />
    <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />
    <title>";
        // line 6
        echo twig_escape_filter($this->env, ((array_key_exists("errorcode", $context)) ? (_twig_default_filter(($context["errorcode"] ?? null), 500)) : (500)), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, ((array_key_exists("error", $context)) ? (_twig_default_filter(($context["error"] ?? null), $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_ENGINE_UNKNOWN_ERROR"))) : ($this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_ENGINE_UNKNOWN_ERROR"))), "html", null, true);
        echo "</title>
    ";
        // line 7
        twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "document", [], "any", false, false, false, 7), "errorPage", [0 => true], "method", false, false, false, 7);
        // line 8
        twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "platform", [], "any", false, false, false, 8), "finalize", [], "method", false, false, false, 8);
        // line 9
        echo twig_join_filter(twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "styles", [0 => "head", 1 => true], "method", false, false, false, 9), "
    ");
        echo "
    ";
        // line 10
        echo twig_join_filter(twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "scripts", [0 => "head", 1 => true], "method", false, false, false, 10), "
    ");
    }

    public function getTemplateName()
    {
        return "partials/error_head.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  69 => 10,  64 => 9,  62 => 8,  60 => 7,  54 => 6,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "partials/error_head.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\media\\gantry5\\engines\\nucleus\\twig\\partials\\error_head.html.twig");
    }
}
