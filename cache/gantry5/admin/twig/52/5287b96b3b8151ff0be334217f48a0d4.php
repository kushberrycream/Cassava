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

/* @gantry-admin/ajax/particles-loss.html.twig */
class __TwigTemplate_1b253970a5b02932f100fff555cc8a44 extends \Twig\Template
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
        $context["sections"] = (("<strong>" . twig_join_filter(($context["particles"] ?? null), "</strong>, <strong>")) . "</strong>");
        // line 2
        echo "
<div class=\"card settings-block\">
    <h4>";
        // line 4
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_LM_PARTICLE_LOSS_WARNING"), "html", null, true);
        echo "</h4>
    <div class=\"inner-params\">

        ";
        // line 7
        if ((twig_length_filter($this->env, ($context["particles"] ?? null)) > 1)) {
            // line 8
            echo "        ";
            echo $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_LM_PARTICLE_LOSS_SECTIONS_X", ($context["sections"] ?? null));
            echo "
        ";
        } else {
            // line 10
            echo "        ";
            echo $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_LM_PARTICLE_LOSS_SECTION_X", ($context["sections"] ?? null));
            echo "
        ";
        }
        // line 12
        echo "        ";
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_LM_PARTICLE_LOSS_TEXT"), "html", null, true);
        echo "
        <br /><br />
        ";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_TO_CONTINUE"), "html", null, true);
        echo "
    </div>
</div>

<div class=\"g-modal-actions\">
    <button tabindex=\"0\" class=\"button button-primary\" role=\"button\" data-g-delete-confirm>";
        // line 19
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_CONTINUE"), "html", null, true);
        echo "</button>
    <button class=\"button button-primary g5-dialog-close\" role=\"button\" data-g-delete-cancel>";
        // line 20
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_CLOSE"), "html", null, true);
        echo "</button>
</div>
";
    }

    public function getTemplateName()
    {
        return "@gantry-admin/ajax/particles-loss.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  81 => 20,  77 => 19,  69 => 14,  63 => 12,  57 => 10,  51 => 8,  49 => 7,  43 => 4,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@gantry-admin/ajax/particles-loss.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\administrator\\components\\com_gantry5\\templates\\ajax\\particles-loss.html.twig");
    }
}
