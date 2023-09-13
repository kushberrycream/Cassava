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

/* @particles/copyright.html.twig */
class __TwigTemplate_836233c881249a5d99d4824f777f3449 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'particle' => [$this, 'block_particle'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@nucleus/partials/particle.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        $context["start_date"] = ((twig_in_filter(twig_trim_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "date", [], "any", false, false, false, 3), "start", [], "any", false, false, false, 3)), [0 => "now", 1 => ""])) ? ($this->env->getFilter('date')->getCallable()($this->env, "now", "Y")) : (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "date", [], "any", false, false, false, 3), "start", [], "any", false, false, false, 3))));
        // line 4
        $context["end_date"] = ((twig_in_filter(twig_trim_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "date", [], "any", false, false, false, 4), "end", [], "any", false, false, false, 4)), [0 => "now", 1 => ""])) ? ($this->env->getFilter('date')->getCallable()($this->env, "now", "Y")) : (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "date", [], "any", false, false, false, 4), "end", [], "any", false, false, false, 4))));
        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/copyright.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 6
    public function block_particle($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        echo "    &copy;
    ";
        // line 8
        if ((($context["start_date"] ?? null) != ($context["end_date"] ?? null))) {
            echo twig_escape_filter($this->env, ($context["start_date"] ?? null));
            echo " - ";
        }
        // line 9
        echo "    ";
        echo twig_escape_filter($this->env, ($context["end_date"] ?? null));
        echo "
    ";
        // line 10
        echo twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "owner", [], "any", false, false, false, 10);
        echo "
";
    }

    public function getTemplateName()
    {
        return "@particles/copyright.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 10,  63 => 9,  58 => 8,  55 => 7,  51 => 6,  46 => 1,  44 => 4,  42 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@particles/copyright.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\media\\gantry5\\engines\\nucleus\\particles\\copyright.html.twig");
    }
}
