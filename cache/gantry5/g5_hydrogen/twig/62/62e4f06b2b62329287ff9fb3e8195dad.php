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

/* @particles/sample.html.twig */
class __TwigTemplate_897a2e13c9bd959c38277eeee539b7b4 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/sample.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_particle($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "\t<div class=\"sample-content\">
\t\t<div class=\"g-grid\">
\t\t\t<div class=\"g-block\">
\t\t\t\t<div class=\"g-content\">
\t\t\t\t\t";
        // line 8
        if (twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "image", [], "any", false, false, false, 8)) {
            echo "<img src=\"";
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc(twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "image", [], "any", false, false, false, 8)), "html", null, true);
            echo "\" class=\"logo-large\" alt=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "headline", [], "any", false, false, false, 8));
            echo "\" />";
        }
        // line 9
        echo "\t\t\t\t\t";
        if (twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "headline", [], "any", false, false, false, 9)) {
            echo "<h1>";
            echo twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "headline", [], "any", false, false, false, 9);
            echo "</h1>";
        }
        // line 10
        echo "\t\t\t\t\t";
        if (twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "description", [], "any", false, false, false, 10)) {
            echo "<div class=\"sample-description\">";
            echo twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "description", [], "any", false, false, false, 10);
            echo "</div>";
        }
        // line 11
        echo "\t\t\t\t\t";
        if (twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "linktext", [], "any", false, false, false, 11)) {
            echo "<p><a href=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "link", [], "any", false, false, false, 11));
            echo "\" class=\"button\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "linktext", [], "any", false, false, false, 11));
            echo "</a></p>";
        }
        // line 12
        echo "\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t\t<div class=\"g-grid\">
\t\t\t";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["particle"] ?? null), "samples", [], "any", false, false, false, 16));
        foreach ($context['_seq'] as $context["_key"] => $context["sample"]) {
            // line 17
            echo "\t\t\t\t<div ";
            if (twig_get_attribute($this->env, $this->source, $context["sample"], "id", [], "any", false, false, false, 17)) {
                echo "id=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["sample"], "id", [], "any", false, false, false, 17));
                echo "\"";
            }
            // line 18
            echo "\t\t\t\t\t class=\"g-block ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["sample"], "class", [], "any", false, false, false, 18), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["sample"], "variations", [], "any", false, false, false, 18), "html", null, true);
            echo "\">
\t\t\t\t\t<div class=\"g-content\">
\t\t\t\t\t\t<i class=\"";
            // line 20
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["sample"], "icon", [], "any", false, false, false, 20), "html", null, true);
            echo " sample-icons\"></i>
\t\t\t\t\t\t<h4>";
            // line 21
            echo twig_get_attribute($this->env, $this->source, $context["sample"], "title", [], "any", false, false, false, 21);
            echo "</h4>
\t\t\t\t\t\t";
            // line 22
            echo twig_get_attribute($this->env, $this->source, $context["sample"], "subtitle", [], "any", false, false, false, 22);
            echo "
\t\t\t\t\t\t";
            // line 23
            echo twig_get_attribute($this->env, $this->source, $context["sample"], "description", [], "any", false, false, false, 23);
            echo "
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sample'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "\t\t</div>
\t</div>
";
    }

    public function getTemplateName()
    {
        return "@particles/sample.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  134 => 27,  124 => 23,  120 => 22,  116 => 21,  112 => 20,  104 => 18,  97 => 17,  93 => 16,  87 => 12,  78 => 11,  71 => 10,  64 => 9,  56 => 8,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@particles/sample.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\templates\\g5_hydrogen\\particles\\sample.html.twig");
    }
}
