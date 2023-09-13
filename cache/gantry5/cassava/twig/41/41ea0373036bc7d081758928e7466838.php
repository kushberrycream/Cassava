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

/* @nucleus/content/spacer.html.twig */
class __TwigTemplate_b4f6bcad427dfaf4e9a36a38fc3f3cec extends \Twig\Template
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
        if ( !($context["particle"] ?? null)) {
            // line 2
            echo "    ";
            $context["enabled"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 2), "get", [0 => (("particles." . twig_get_attribute($this->env, $this->source, ($context["segment"] ?? null), "type", [], "any", false, false, false, 2)) . ".enabled"), 1 => 1], "method", false, false, false, 2);
            // line 3
            echo "    ";
            $context["spacer"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 3), "getJoined", [0 => ("particles." . twig_get_attribute($this->env, $this->source, ($context["segment"] ?? null), "type", [], "any", false, false, false, 3)), 1 => twig_get_attribute($this->env, $this->source, ($context["segment"] ?? null), "attributes", [], "any", false, false, false, 3)], "method", false, false, false, 3);
        }
        // line 5
        echo "
";
        // line 6
        if ((($context["enabled"] ?? null) && ((null === twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["segment"] ?? null), "attributes", [], "any", false, false, false, 6), "enabled", [], "any", false, false, false, 6)) || twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["segment"] ?? null), "attributes", [], "any", false, false, false, 6), "enabled", [], "any", false, false, false, 6)))) {
            // line 7
            echo "    <div class=\"spacer";
            ((twig_get_attribute($this->env, $this->source, ($context["segment"] ?? null), "classes", [], "any", false, false, false, 7)) ? (print (twig_escape_filter($this->env, (" " . twig_escape_filter($this->env, twig_join_filter(twig_get_attribute($this->env, $this->source, ($context["segment"] ?? null), "classes", [], "any", false, false, false, 7), " "))), "html", null, true))) : (print ("")));
            echo "\"></div>
";
        }
    }

    public function getTemplateName()
    {
        return "@nucleus/content/spacer.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 7,  49 => 6,  46 => 5,  42 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@nucleus/content/spacer.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\media\\gantry5\\engines\\nucleus\\templates\\content\\spacer.html.twig");
    }
}
